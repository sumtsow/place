<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposition extends Model
{
	
    protected $casts = [
		'is_enabled' => 'boolean',
	];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
		'distributor_item_id',
		'count',
		'is_enabled',
    ];

	private static $emptyModel = [
		'id' => 0,
		'order_id' => 0,
		'distributor_item_id' => 0,
		'count' => 0,
		'is_enabled' => false,
		'distributor_item' => [
			'id' => 0,
			'distributor_id' => 0,
			'item_id' => 0,
		],
	];

	//protected $with = [ 'distributorItem' ];

	/**
     * Get the distributor that sell the order
     */
    public function distributorItem(): BelongsTo
    {
		return $this->belongsTo(DistributorItem::class);
    }

	/**
	* Get the order that contains the proposition.
	*/
	public function order(): BelongsTo
	{
		return $this->belongsTo(Order::class);
	}

	public static function getEmptyModel() {
		return self::$emptyModel;
	}
}
