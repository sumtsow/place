<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Return all parent categories links.
     */
    public function getParentLinks()
    {
		$links = [];
		$parent = $this->parentCategory;
		$links[] = [
			'title' => $this->name,
			'route' => false,
		];
		while ($parent) {
			$links[] = [
				'title' => $parent->name,
				'route' => 'category',
				'param' => [$parent->id],
			];
			$parent = $parent->parentCategory;
		};
		return array_reverse( $links );
    }
}
