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
            'email'      => 'required|email|unique:users,email',
            'role'       => 'required|in:Admin,Member',
            'name'       => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'ERROR',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = auth()->user();

        // Only SuperAdmin can invite Admins, and only to an existing company
        if ($request->role === 'Admin') {
            if ($user->role !== 'SuperAdmin') {
                abort(403, 'Only SuperAdmin can invite Admins.');
            }
            if (empty($user->company_id)) {
                abort(403, 'SuperAdmin must belong to a company to invite Admins.');
            }
            $company_id = $user->company_id;
        } else {
            // Only Admin can invite Members in their own company
            if ($user->role !== 'Admin') {
                abort(403, 'Only Admin can invite Members.');
            }
            $company_id = $user->company_id;
        }

        $invitedUser             = new User();
        $invitedUser->name       = $request->name;
        $invitedUser->email      = $request->email;
        $invitedUser->role       = $request->role;
        $invitedUser->company_id = $company_id;
        $invitedUser->password   = Hash::make(Str::random(12)); // Temporary password

        $invitedUser->save();

        return redirect()->route('invite.index')
            ->with('success', 'Invitation sent successfully.');
    }

}
