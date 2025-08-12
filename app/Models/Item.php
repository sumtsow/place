<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class Item extends Model
{
	/**
     * Get the categories that contains the item
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_has_item')->withPivot('is_main')->withTimestamps();
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
        return $this->belongsToMany(Distributor::class, 'distributor_has_item')->withPivot('count', 'price', 'discount', 'delivery', 'is_enabled')->withTimestamps();
    }

	/**
     * Get the parameters that has the item
     */
    public function parameters(): BelongsToMany
    {
        return $this->belongsToMany(Parameter::class)->withPivot('value')->withTimestamps();
    }

	/**
     * Return all items.
     */
	public static function getList()
	{
		return self::orderBy('name')->with(['categories', 'mainCategory', 'unit'])->limit(100)->get();
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

	/**
     * Return prepared update changes.
     */
    private function getUpdates( $data )
    {
		$changes = [
			'updated' => [],
			'added' => [],
			'removed' => [],
		];
		$new = array_unique(Arr::pluck($data, 'id'));
		$old = $this->categories->pluck('id')->all();
		$updated = array_diff($new, $old);
		if ( count($new) > count($old) ) {
			foreach ($new as $key => $cat) {
				if ( isset( $old[$key] ) ) {
					if ( $cat !== $old[$key] ) {
						$changes['updated'][$key] = $cat;
					}
				} else {
					$changes['added'][$key] = $cat;
				};
			};
		} elseif ( count($new) < count($old) ) {
			$changes['removed'] = array_diff( $old, $new );
		} else {
			$changes['updated'] = $updated;
		}
		return $changes;
    }

	/**
     * Update main Category of Item.
     */
    private function updateMainCategory( $data )
    {
		foreach($data as $cat) {
			$this->categories()->updateExistingPivot($cat['id'], [ 'is_main' => $cat['pivot']['is_main'] ? 1 : 0 ]);
		}
		$main = $this->mainCategory->first();
		if ( !$main ) {
			$main = ( count($data) === 1 ) ? $data[0] : $this->categories()->first()->toArray();
			$this->categories()->updateExistingPivot($main['id'], [ 'is_main' => 1 ]);
		}
		return $main;
    }

	/**
     * Check categories updates
     */
    public function updateCategories($postData)
    {
		if (!$postData) return false;
		$updates = $this->getUpdates( $postData );
		foreach ($updates['updated'] as $key => $cat) {
			$this->categories()->updateExistingPivot($old[$key], [
				'category_id' => $cat,
			]);
		}
		$this->categories()->attach($updates['added']);
		$this->categories()->detach($updates['removed']);
		$this->updateMainCategory( $postData );
		return $updates;
    }
}
