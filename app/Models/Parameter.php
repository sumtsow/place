<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
	/**
     * Get the items that use with this parameter
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_has_parameter')->withPivot('value');
    }
}
