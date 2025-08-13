<?php
namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $invitations = Invitation::query();

    if ($user->role === 'SuperAdmin') {
    } elseif ($user->role === 'Admin') {
        $invitations->where('company_id', $user->company_id);
    } elseif ($user->role === 'Member') {
        $invitations->where('user_id', $user->id);
    }

    return view('invitations.index', [
        'invitations' => $invitations->get()
    ]);
}

    public function create()
    {
        return view('invitations.create');
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|unique:invitations,email',
        'role'  => 'required|in:Admin,Member',
        'company_id' => 'nullable|exists:companies,id'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'ERROR',
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $user = auth()->user();
    if (
        $user->role === 'SuperAdmin' &&
        $request->role === 'Admin' &&
        empty($request->company_id)
    ) {
        abort(403, 'SuperAdmin can’t invite an Admin in a new company.');
    }
    if (
        $user->role === 'Admin' &&
        in_array($request->role, ['Admin', 'Member']) &&
        $request->company_id == $user->company_id
    ) {
        abort(403, 'Admin can’t invite another Admin or Member in their own company.');
    }

    $invitation = new Invitation();
    $invitation->email      = $request->email;
    $invitation->role       = $request->role;
    $invitation->user_id    = $user->id;
    $invitation->company_id = $user->company_id ?? null;
    $invitation->token      = Str::uuid();

    $invitation->save();

    return redirect()->route('invite.index')
        ->with('success', 'Invitation sent successfully.');
}

}
