<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;

class InvitationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user): bool
    {
        // Only SuperAdmin and Admin can invite, but with restrictions
        return in_array($user->role, ['SuperAdmin', 'Admin']);
    }

    /**
     * Determine if the user can invite a specific role to a company
     */
    public function canInvite(User $user, string $inviteRole, ?int $companyId = null): bool
    {
        if ($user->role === 'SuperAdmin') {
            // SuperAdmin cannot invite Admins to a new company
            if ($inviteRole === 'Admin' && $companyId !== $user->company_id) {
                return false;
            }
            return true;
        }
        if ($user->role === 'Admin') {
            // Admin cannot invite another Admin or Member in their own company
            if ($companyId === $user->company_id && in_array($inviteRole, ['Admin', 'Member'])) {
                return false;
            }
            return true;
        }
        // Other roles cannot invite
        return false;
    }
}
