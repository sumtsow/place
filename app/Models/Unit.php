<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
	/**
     * Get the items that use this unit.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

	/**
     * Get the parameters that use this unit.
     */
    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class);
    }
}
