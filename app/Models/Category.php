<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
	protected $casts = [
		'is_enabled' => 'boolean',
	];
	/**
     * Get the items for the category.
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'category_has_item')->withPivot('is_main')->withTimestamps();
    }

	/**
     * Get the subcategories for the category.
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(self::class, 'category_id');
    }

	/**
     * Get the category that contains the subcategory
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(self::class, 'category_id');
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

	/**
     * Return all categories with its subcategories.
     */
	public static function getCatList()
	{
		$cats = self::orderBy('name')->where('category_id', null)->get();
		foreach ($cats as $cat) {
			self::loadSubcategories($cat);
		}
		return $cats;
	}

	/**
     * Return plain list of categories and its subcategories.
     */
	public static function getPlainCatList()
	{
		return self::getSubcategories(self::getCatList(), 0);
	}

	/**
     * Return subcategories plain array.
     */
	public static function getSubcategories($subArray, $level)
	{
		$list = [];
		foreach ($subArray as $cat) {
			$hasChildren = !!($cat->subcategories->count());
			$list[] = [
				'id' => $cat->id,
				'name' => $cat->name,
				'level' => $level,
				'logo' => $cat->logo,
				'hasChildren' => $hasChildren,
				'itemCount' => $cat->items()->count(),
			];
			$sub = [];
			if ($hasChildren) {
				$level++;
				$sub = self::getSubcategories($cat->subcategories, $level);
				$level--;
			}
			$list = array_merge($list, $sub);
		}
		return $list;
	}
	/**
     * Return all subcategories list.
     */
	private static function loadSubcategories($cat) {
		$cat->loadMissing(['subcategories', 'items']);
		foreach ($cat->subcategories as $sub) {
			self::loadSubcategories($sub);
		}
		return true;
	}
}
