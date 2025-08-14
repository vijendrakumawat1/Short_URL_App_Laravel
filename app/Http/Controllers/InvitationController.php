<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class InvitationController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $invitations = User::with('company');

    if ($user->role === 'SuperAdmin') {
    } elseif ($user->role === 'Admin') {
        $invitations->where('company_id', $user->company_id);
    } elseif ($user->role === 'Member') {
        $invitations->where('id', $user->id);
    }

    return view('invitations.index', [
        'invitations' => $invitations->get(),
    ]);
}


    public function create()
    {
        return view('invitations.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'      => 'required|email|unique:invitations,email',
            'role'       => 'required|in:Admin,Member',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'ERROR',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = auth()->user();
        if ($request->role === 'Admin' && empty($request->company_id)) {
            abort(403, 'SuperAdmin can’t invite an Admin in a new company.');
        }
        if (
            $user->role === 'Admin' &&
            in_array($request->role, ['Admin', 'Member']) &&
            $request->company_id == $user->company_id
        ) {
            abort(403, 'Admin can’t invite another Admin or Member in their own company.');
        }

        $invitation             = new User();
        $invitation->name       = $request->name;
        $invitation->email      = $request->email;
        $invitation->role       = $request->role;
        $invitation->company_id = $user->company_id ?? null;
        $invitation->password   = Hash::make('Admin@123'); // Temporary password

        $invitation->save();

        return redirect()->route('invite.index')
            ->with('success', 'Invitation sent successfully.');
    }

}
