<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Unit extends Model
{
	private static $emptyModel = [
		'name' => '',
		'type' => 0,
		'is_enabled' => 1,
	];

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

	public static function getEmptyModel() {
		return self::$emptyModel;
	}

	public static function validSortField( $field ) {
		$fieldList = Schema::getColumnListing('units');
		return in_array( $field, $fieldList ) ? $field : $fieldList[0];
	}

	public static function validOrder( $order ) {
		return $order && in_array( $order, config('app.sortOrder') ) ? $order : config('app.sortOrder')[0];
	}
}
