<?php

namespace App\Policies;

use App\Models\User;

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

	/**
     * Determine if the logged user is manager.
     */
    public function manager(User $user)
    {
        return $user->roles->contains('name', 'manager');
    }

	/**
     * Determine if the logged user is customer.
     */
    public function customer(User $user)
    {
        return $user->roles->contains('name', 'customer');
    }
	
}
