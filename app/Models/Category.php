<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	/**
     * Get the items for the category.
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'category_has_item')->withPivot('is_main');
    }

	/**
     * Get the subcategories for the category.
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'category_id');
    }

	/**
     * Get the category that contains the subcategory
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
