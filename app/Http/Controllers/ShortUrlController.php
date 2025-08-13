<?php
namespace App\Http\Controllers;

use App\Models\ShortUrl; // <-- Import this

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    use AuthorizesRequests; // <-- Add this line

    public function index()
    {
        $user = auth()->user();
        $urls = ShortUrl::all()->filter(function($url) use ($user) {
            return app(\App\Policies\ShortUrlPolicy::class)->view($user, $url);
        });
        return view('shorturls.index', ['urls' => $urls]);
    }

    public function create()
    {
        $this->authorize('create', ShortUrl::class);

        return view('shorturls.create');

    }

    public function store(Request $request)
    {

        $this->authorize('create', ShortUrl::class);
        
        $validator = Validator::make($request->all(), [
            'long_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'ERROR', 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        $shortUrl             = new ShortUrl();
        $shortUrl->long_url   = $request->long_url;
        $shortUrl->short_code = substr(md5(uniqid()), 0, 6);
        $shortUrl->user_id    = auth()->user()->id;
        $shortUrl->company_id = auth()->user()->company_id;
        $shortUrl->save();

        return redirect()->route('shorturls.index')->with('success', 'Short URL created');
    }

    public function redirect($code)
    {
        $user = auth()->user();
        abort_unless($user, 403);
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();
        // Only allow redirect if user can view this short URL
        if (!app(\App\Policies\ShortUrlPolicy::class)->view($user, $shortUrl)) {
            abort(403);
        }
        return redirect()->away($shortUrl->long_url);
    }

}
