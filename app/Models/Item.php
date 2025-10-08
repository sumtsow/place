<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class Item extends Model
{
	protected $casts = [
		'is_enabled' => 'boolean',
	];

	private static $emptyModel = [
		'unit_id' => 0,
		'name' => '',
		'is_enabled' => 0,
		'description' => '',
		'images' => '',
	];

	/**
     * Get the categories that contains the item
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_has_item')->withPivot('is_main')->withTimestamps();
    }

	/**
     * Get the distributors who sell this item
     */
    public function distributorItems(): HasMany
    {
		return $this->hasMany(DistributorItem::class);
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
     * Get the parameters that has the itemparentCategory
     */
    public function parameters(): BelongsToMany
    {
        return $this->belongsToMany(Parameter::class, 'item_has_parameter')->with(['unit'])->withPivot('value')->withTimestamps();
    }

	/**
     * Return all items.
     */
	public static function getList($category_id = null)
	{
		$items = [];
		if ($category_id) {
			$ids = 0;
			$items = self::whereHas('categories', function (Builder $query) use ($category_id) {
					$query->where('categories.id', '=', $category_id);
				})
				->orderBy('name')
				->with([ 'categories', 'mainCategory', 'unit', 'parameters', 'posts' ])
				->paginate( env('ITEMS_PER_PAGE') )
				->withQueryString();
		} else {
			$items = self::orderBy('name')->with([ 'categories', 'mainCategory', 'unit', 'parameters', 'posts' ])->paginate( env('ITEMS_PER_PAGE') )->withQueryString();
		}
		//dd($items); die();
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

	/**
     * Return prepared update changes.
     */
    private function getCategoryUpdates( $data )
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

	public static function getEmptyModel() {
		return self::$emptyModel;
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
     * Apply categories updates
     */
    public function updateCategories($postData)
    {
		if (!$postData) return false;
		$updates = $this->getCategoryUpdates( $postData );
		$old = $this->categories->pluck('id')->all();
		$updatedCats = Category::whereIn('id', $updates['updated'])->with('subcategories')->get();
		foreach ($updates['updated'] as $key => $cat) {
			if ( !$updatedCats->findOrFail($cat)->subcategories()->count() ) {
				$this->categories()->updateExistingPivot($old[$key], [
					'category_id' => $cat,
				]);
			}
		}
		$this->categories()->attach($updates['added']);
		$this->categories()->detach($updates['removed']);
		$this->updateMainCategory( $postData );
		return $updates;
    }

	
	/**
     * Apply Parameter`s updates
     */
    public function updateParameters($data)
    {
		if (!$data) return false;
		$changes = [
			'updated' => [],
			'added' => [],
			'removed' => [],
		];
		$new = array_unique(Arr::pluck($data, 'id'));
		$old = $this->parameters->pluck('id')->all();
		$updated = array_diff($new, $old);
		if ( count($new) > count($old) ) {
			foreach ($new as $key => $param) {
				if ( isset( $old[$key] ) ) {
					if ( $param !== $old[$key] ) {
						$changes['updated'][$key] = $param;
					}
				} else {
					$changes['added'][$key] = $param;
				};
			};
		} elseif ( count($new) < count($old) ) {
			$changes['removed'] = array_diff( $old, $new );
		} else {
			$changes['updated'] = $updated;
		}
		//dd($data, $changes); die();
		foreach ($changes['updated'] as $key => $param) {
			$this->parameters()->updateExistingPivot($old[$key], [
				'parameter_id' => $param,
			]);
		}
		$this->parameters()->attach($changes['added']);
		$this->parameters()->detach($changes['removed']);
		return $changes;
    }

	public static function getEnumValues($tablename, $fieldname)
	{
		$values = DB::select("DESCRIBE `$tablename` `$fieldname`");
        $values = explode(',',str_replace("'","",substr($values[0]->Type,5,-1)));
		return $values;
	}
}
