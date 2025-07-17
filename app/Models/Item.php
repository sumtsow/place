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
     * Get the main category that contains the item
     */
    public function mainCategory(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_has_item')->wherePivot('is_main', 1);
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

	/**
     * Return all items.
     */
	public static function getList()
	{
		$items = self::orderBy('name')->with(['categories', 'unit'])->limit(100)->get();
		return $items;
	}

	/**
     * Return all parent categories links.
     */
    public function getCategoryLinks()
    {
		$links = [];
		$category = $this->mainCategory->firstOrFail();
		if ($category) {
			$links = $category->getParentLinks();
			$last = count($links) - 1;
			$links[$last]['route'] = 'category';
			$links[$last]['param'] = [ $category->id ];
			$links[] = [
				'title' => $this->name,
				'route' => false,
			];
		}
		return $links;
    }
}
