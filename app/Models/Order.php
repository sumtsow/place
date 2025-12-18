<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Order extends Model
{
	protected $casts = [
		'is_enabled' => 'boolean',
	];

	protected $with = ['propositions'];

	protected $appends = ['totalPrice'];

	private static $emptyModel = [
		'id' => 0,
		'customer_id' => 0,
		'is_enabled' => false,
		'status' => 'undefined',
		'expired' => null,
		'address' => '',
	];

	/**
     * Get the cusomer for the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'customer_id');
    }

	/**
     * Get the propositions contained in order
     */
	public function propositions(): HasMany
	{
		return $this->hasMany(Proposition::class);
	}
	
	public static function getEmptyModel() {
		return self::$emptyModel;
	}

    /**
     * Get the item's price with a discount.
     */
    public function getTotalPriceAttribute()
    {
        $total = 0;
		$prop = [];
		foreach($this->propositions as $proposition) {
			if ( $proposition->is_enabled ) {
				$total += $proposition->distributorItem->discountPrice * $proposition->count;
				$prop[] = $proposition->distributorItem->id . ' - ' . $proposition->distributorItem->item->name . ' - ' . $proposition->distributorItem->discountPrice . ' x ' . $proposition->count;
			}
		}
		return $total;
    }

	public static function validSortField( $field ) {
		$fieldList = Schema::getColumnListing('orders');
		return in_array( $field, $fieldList ) ? $field : $fieldList[0];
	}
}
