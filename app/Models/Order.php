<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
	protected $casts = [
		'is_enabled' => 'boolean',
	];

	private static $emptyModel = [
		'id' => 0,
		'customer_id' => 0,
		'is_enabled' => false,
		'status' => 'undefined',
		'address' => '',
	];

	/**
     * Get the cusomer for the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'customer_id')->withTimestamps();
    }

	/**
     * Get the items contained in order
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'order_has_distributor_item')->withPivot('order_id', 'distributor_item_id', 'count', 'expired', 'is_enabled')->withTimestamps();
    }

	public static function getEmptyModel() {
		return self::$emptyModel;
	}
}
