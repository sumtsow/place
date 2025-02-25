<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;

class UserPolicy
{
    /**
     * Determine if the logged user is admin.
     */
    public function admin(User $user)
    {
        return $user->roles->contains('name', 'admin');
    }

	/**
     * Determine if the logged user is operator.
     */
    public function operator(User $user)
    {
        return $user->roles->contains('name', 'operator');
    }
}
