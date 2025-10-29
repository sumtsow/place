<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryItem extends Pivot
{
    protected $casts = [
		'is_main' => 'boolean',
	];
}
