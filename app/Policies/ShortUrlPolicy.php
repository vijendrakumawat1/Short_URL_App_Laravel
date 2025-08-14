<?php

namespace App\Policies;
use App\Models\ShortUrl;
use App\Models\User;

class ShortUrlPolicy
{
    /**
     * Create a new policy instance.
     */
    public function create(User $user)
    {
        // Only Admin and Member can create short URLs
        return in_array($user->role, ['Admin', 'Member']);
    }

    public function view(User $user, ShortUrl $url)
    {
        if ($user->role === 'SuperAdmin') {
            // SuperAdmin can view all short URLs
            return true;
        }
        if ($user->role === 'Admin') {
            // Admin can only see short URLs created in their own company
            return $user->company_id === $url->company_id;
        }
        if ($user->role === 'Member') {
            // Member can only see short URLs created by themselves
            return $user->id === $url->user_id;
        }
        return false;
    }


}
