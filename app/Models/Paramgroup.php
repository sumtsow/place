<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paramgroup extends Model
{
	protected $casts = [
		'is_enabled' => 'boolean',
	];

	/**
     * Get the items that use with this parameter
     */
    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class, 'paramgroup_id');
    }
}
