<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    /**
     * Get the user that owns the role
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTimestamps();
    }

	/**
     * Get the distributor that managed by role
     */
    public function distributor(): BelongsTo
    {
        return ($this->name === 'manager') ? $this->belongsTo(Distributor::class)->withTimestamps() : null;
    }

	/**
     * Get the orders for the customer.
     */
    public function orders(): HasMany
    {
        return ($this->name === 'customer') ? $this->belongsTo(Order::class)->withTimestamps() : null;
    }
}
