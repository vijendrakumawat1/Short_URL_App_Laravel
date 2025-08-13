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
        // No one can create short URLs
        return false;
    }

public function view(User $user, ShortUrl $url)
{
    if ($user->role === 'SuperAdmin') {
        // SuperAdmin cannot view any short URLs
        return false;
    }
    if ($user->role === 'Admin') {
        // Admin can only see short URLs not created in their own company
        return $user->company_id !== $url->user->company_id;
    }
    if ($user->role === 'Member') {
        // Member can only see short URLs not created by themselves
        return $user->id !== $url->user_id;
    }
    return false;
}


}
