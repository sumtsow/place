<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Paramgroup extends Model
{
	protected $casts = [
		'is_enabled' => 'boolean',
	];

	private static $emptyModel = [
		'name' => '',
		'order' => 0,
		'is_enabled' => false,
	];

	public static function getEmptyModel() {
		return self::$emptyModel;
	}

	/**
     * Get the collection of parameters that group contains
     */
    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class, 'paramgroup_id');
    }

	public static function validSortField( $field ) {
		$fieldList = Schema::getColumnListing('paramgroups');
		return in_array( $field, $fieldList ) ? $field : $fieldList[0];
	}
}
