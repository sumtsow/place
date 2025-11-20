<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DistributorItem extends Model
{
	protected $table = 'distributor_has_item';

	protected $with = ['distributor'];

	protected $casts = [
		'is_enabled' => 'boolean',
	];

	protected $appends = ['discountPrice'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'item_id',
		'distributor_id',
		'count',
		'price',
		'discount',
		'delivery',
		'is_enabled',
		'url',
    ];

	private static $emptyModel = [
		'id' => 0,
		'item_id' => 0,
		'distributor_id' => 0,
		'count' => 0,
		'price' => '0.00',
		'discount' => 0,
		'delivery' => '',
		'is_enabled' => false,
		'url' => '',
	];

	/**
     * Get the propositions of item for the distributor.
     */
    public function propositions(): HasMany
    {
        return $this->hasMany(Proposition::class);
    }

	/**
     * Get the distributor that sell the item
     */
    public function distributor(): BelongsTo
    {
        return $this->BelongsTo(Distributor::class);
    }

	/**
     * Get the item that propose by distributor
     */
    public function item(): BelongsTo
    {
        return $this->BelongsTo(Item::class);
    }

	public static function getEmptyModel() {
		return self::$emptyModel;
	}

    /**
     * Get the item's price with a discount.
     */
    public function getDiscountPriceAttribute()
    {
        return round( $this->price * ( ( 1 - 0.01 * $this->discount ) ), 2);
    }
}
