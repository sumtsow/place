<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
	/**
     * Get the categories that contains the item
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_has_item')->withPivot('is_main');
    }

	/**
     * Get the unit that use with this item
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

	/**
     * Get the posts for the item.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

	/**
     * Get the distributors that sell the item
     */
    public function distributors(): BelongsToMany
    {
        return $this->belongsToMany(Distributor::class, 'distributor_has_item')->withPivot('count', 'price', 'discount', 'delivery', 'is_enabled');
    }

	/**
     * Get the parameters that has the item
     */
    public function parameters(): BelongsToMany
    {
        return $this->belongsToMany(Parameter::class)->withPivot('value');
    }
}
