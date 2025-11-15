<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class Item extends Model
{
	protected $casts = [
		'is_enabled' => 'boolean',
	];

	public const IMAGE_DIR = 'img';
	public const IMAGE_TYPES =  [ 'image/png', 'image/jpeg' ];
	public const IMAGE_SIZE =  165;
	
	private static $emptyModel = [
		'unit_id' => 0,
		'name' => '',
		'like' => 0,
		'is_enabled' => 0,
		'description' => '',
		//'images' => '',
		'categories' => [],
	];

	private static $emptyValue = [
		'item_id' => 0,
		'parameter_id' => 0,
		'value' => null,
	];

	/**
     * Get the categories that contains the item
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_has_item')->using(CategoryItem::class)->withPivot('is_main')->withTimestamps();
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

	public function deleteImage(string $filename) {
		if (!$filename) return false;
		$imageParams = self::parseImageFileName($filename);
		if ( !$imageParams ) return false;
		$images = json_decode( $this->images );
		if ( ( $delKey = array_search( $filename, $images ) ) !== false ) {
			Arr::pull( $images, $delKey);
			$images = array_values( $images );
			$file = '/' . self::IMAGE_DIR . '/' . $filename;
			if( Storage::disk('public')->exists( $file ) ) {
				Storage::disk('public')->delete( $file );
			}
			$count = count($images);
			for( $i = $delKey; $i < $count; $i++ ) {
				$ext = explode('.', $images[ $i ] )[1];
				$oldName = $images[ $i ];
				$images[ $i ] = $this->getImageFileName( $i + 1, $ext );
				Storage::disk('public')->move('/' . self::IMAGE_DIR . '/' . $oldName, '/' . self::IMAGE_DIR . '/' . $images[ $i ]);
			}
			$this->images = json_encode( $images );
		}
		return false;
	}

	public function formatNumber( $number )
	{
		return sprintf( '%0'.config('app.imageNumberMaxLength').'d', intval( $number ) );
	}

	/**
     * Check image file exists
     */
	public function imageFileExists( $filename )
	{
		return Storage::disk('public')->exists( '/' . self::IMAGE_DIR . '/' . $filename );
	}

	/**
     * Check image file exists
     */
	public function imageResize( $file, $type, $filename )
	{
		if ( !$file || !$type || !$filename ) return false;
		if ( !in_array( $type, self::IMAGE_TYPES ) ) return false;
		list($width, $height) = getimagesize($file);
		$ratio = $width / $height;
		if( $ratio > 1 ) {
			$newWidth = self::IMAGE_SIZE;
			$newHeight = round( self::IMAGE_SIZE / $ratio );
		} else {
			$newHeight = self::IMAGE_SIZE;
			$newWidth = round( self::IMAGE_SIZE * $ratio );
		}
		//dd( storage_path( 'app/public/' . self::IMAGE_DIR ) . '/' . $filename ); die();
		if( $type === self::IMAGE_TYPES[0] ) {
			$image = imagecreatefrompng($file);
			$imageResized = imagescale($image , $newWidth, $newHeight);
			imagepng($imageResized, storage_path( 'app/public/' . self::IMAGE_DIR ) . '/' . $filename );
		} else {
			$image = imagecreatefromjpeg($file);
			$imageResized = imagescale($image , $newWidth, $newHeight);
			imagejpeg($imageResized, storage_path( 'app/public/' . self::IMAGE_DIR ) . '/' . $filename ); 
		}
		return true;
	}

	/**
     * Return image file name for got params
     */
	public function getImageFileName( $id, $ext )
	{
		return $id && $ext ? 'item-' . $this->id . '-image-' . $this->formatNumber($id) . '.' . $ext : false;
	}

	/**
     * Generate new image file name
     */
	public function newImageFileName( $ext )
	{
		if(!$ext) return false;
		$images = $this->images ? json_decode( $this->images ) : [];
		$index = count($images) + 1;
		if ( $index >= ( 10 ** config('app.imageNumberMaxLength') ) ) return false;
		do {
			$filename = $this->getImageFileName( $index++, $ext );
		} while( $this->imageFileExists( $filename ) );
		return $filename;
	}
	
	/**
     * Return all items.
     */
	public static function getList($category_id = null)
	{
		return $category_id ? self::whereHas('categories', function (Builder $query) use ($category_id) {
						$query->where('categories.id', '=', $category_id);
					})->orderBy('name')
					->with([ 'categories', 'mainCategory', 'unit', 'parameters', 'posts' ])
					->paginate( env('ITEMS_PER_PAGE') )
					->withQueryString()
				: self::orderBy('name')->with([ 'categories', 'mainCategory', 'unit', 'parameters', 'posts' ])
					->paginate( env('ITEMS_PER_PAGE') )
					->withQueryString();
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
     * Return newest Items
     */
    public static function getMainPageItems()
    {
		return [
			'newest' => self::orderByDesc('updated_at')->limit(env('ITEMS_ON_MAIN_PAGE'))->get(),
			'discussed' => self::withCount(['posts'])->orderByDesc('posts_count')->limit(env('ITEMS_ON_MAIN_PAGE'))->get(),
			'liked' => self::orderByDesc('like')->limit(env('ITEMS_ON_MAIN_PAGE'))->get(),
		];
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

	public static function getEmptyValue() {
		return self::$emptyValue;
	}

	public function getStoredImages() {
		$prefix = 'item-' . $this->id . '-image-';
		$filtered = Arr::where(Storage::disk('public')->files( Item::IMAGE_DIR ), function (string $value) use ( $prefix ) {
			return str_contains( $value, $prefix );
		});
		return $filtered;
	}

	public static function parseImageFileName(string $filename ) {
		if ( !$filename) return false;
		$parts = explode( '-', $filename );
		$item_id = intval( $parts[1] );
		if ( !$item_id ) return false;
		$image_id = explode( '.', $parts[3] );
		$image_id = intval( $image_id[0] );
		if ( !$image_id ) return false;
		return [
			'item_id' => $item_id,
			'image_id' => $image_id,
		];
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
