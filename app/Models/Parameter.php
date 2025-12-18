<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Schema;

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
		'is_enabled' => false,
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

	public static function validSortField( $field ) {
		$fieldList = Schema::getColumnListing('parameters');
		return in_array( $field, $fieldList ) ? $field : $fieldList[0];
	}
}
