<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
	/**
     * Get the managers for the distributor.
     */
    public function managers(): HasMany
    {
        return $this->hasMany(Role::class);
    }

	/**
     * Get the items selled by
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'distributor_has_item')->withPivot('count', 'price', 'discount', 'delivery', 'is_enabled');
    }
}
