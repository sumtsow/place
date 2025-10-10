<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parameter extends Model
{
	protected $casts = [
		'is_enabled' => 'boolean',
	];

	private static $emptyModel = [
		'id' => 0,
		'unit_id' => 0,
		'paramgroup_id' => 0,
		'name' => '',
		'order' => 0,
		'is_enabled' => '0',
	];

	/**
     * Get the items that use with this parameter
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_has_parameter')->withPivot('value')->withTimestamps();
    }

	/**
     * Get the unit that use with this parameter
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

	/**
     * Get the group that contains this parameter
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Paramgroup::class, 'paramgroup_id');
    }

	public static function getEmptyModel() {
		return self::$emptyModel;
	}
}
