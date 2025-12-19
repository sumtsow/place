<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Distributor extends Model
{
	public const RELATED =  [ 'items' ];

	protected $casts = [
		'is_enabled' => 'boolean',
	];

	private static $emptyModel = [
		'name' => '',
		'is_enabled' => false,
		'url' => '',
		'email' => '',
		'phone' => '',
		'like' => 0,
		'dislike' => 0,
		'sales' => 0,
	];

	/**
     * Get the managers for the distributor.
     */
    public function managers(): HasMany
    {
        return $this->hasMany(Role::class);
    }

	/**
     * Get the items selled by
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'distributor_has_item')->withPivot('count', 'price', 'discount', 'delivery', 'is_enabled', 'url');
    }

	/**
     * Get the items selled by distributor
     */
    public function distributorItems(): HasMany
    {
		return $this->hasMany(DistributorItem::class);
    }

	public static function getEmptyModel() {
		return self::$emptyModel;
	}

	public static function validSortField( $field ) {
		$fieldList = Schema::getColumnListing('distributors');
		$exists = in_array( $field, $fieldList );
		if ( !$exists ) {
			$exists = in_array( $field, self::RELATED );
		}
		return $exists ? $field : $fieldList[0];
	}
}
