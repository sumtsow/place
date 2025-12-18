<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
	private static $emptyModel = [
		'name' => '',
		'type' => 0,
		'is_enabled' => 1,
	];

	private static $sortFields = [
		'id',
		'name',
		'type',
		'is_enabled',
		'created_at',
		'updated_at',
	];

	private static $orders = [
		'asc',
		'desc',
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
		return $field && in_array( $field, self::$sortFields ) ? $field : self::$sortFields[0];
	}

	public static function validOrder( $order ) {
		return $order && in_array( $order, self::$orders ) ? $order : self::$orders[0];
	}
}
