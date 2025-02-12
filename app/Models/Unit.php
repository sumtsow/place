<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
	/**
     * Get the items that use this unit.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
