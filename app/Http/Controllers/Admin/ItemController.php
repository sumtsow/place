<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Parameter;
use App\Models\Paramgroup;
use App\Models\Post;
use App\Models\Unit;
use App\Http\Requests\DeleteImageRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Requests\UpdateItemParamRequest;
use App\Http\Requests\UpdateValueRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
	 * @param string $category_id
	 * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request, string $category_id = '0')
    {
		$sort = Item::validSortField( $request->sort );
		$order = Unit::validOrder( $request->order );
        return Inertia::render('Admin/ItemsList', [
			'items' => Item::getList($category_id, $sort, $order),
			'item' => Item::getEmptyModel(),
			'units' => Unit::all(),
			'categories' => Category::getPlainCatList(),
			'category_id' => $category_id,
			'emptyPost' => Post::getEmptyModel(),
			'emptyComment' => Comment::getEmptyModel(),
			'description_rows' => config('app.descriptionRowsOnItemAdminPage'),
			'image_max' => config('app.imageNumberMaxLength'),
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/ItemEdit', [
			'item' => new Item(),
			'emptyItem' => Item::getEmptyModel(),
			'categories' => Category::getPlainCatList(),
			'units' => Unit::all(),
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateItemRequest $request)
    {
        $item = new Item();
		$item->unit_id = $request->input('unit_id') ? $request->input('unit_id') : null;
		$item->name = $request->input('name');
		$item->like = $request->input('like');
		$item->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$item->description = $request->input('description') ?? null;
		//$item->images = $request->input('images') ?? null;
		$item->save();
		$item->updateCategories($request->input('categories'));
    }

    /**
     * Show the specified Item with it`s Parameters.
     */
    public function show(string $id, string $group_id = null)
    {
        return Inertia::render('Admin/ItemShow', [
			'item' => Item::with(['parameters' => function (Builder $query) {
					$query->leftJoin('paramgroups', 'paramgroups.id', '=', 'parameters.paramgroup_id')->orderByRaw('ISNULL(paramgroups.order), paramgroups.order, parameters.order');
				}])->findOrFail($id),
			'parameters' => $group_id ? Parameter::where('paramgroup_id', $group_id)->orderBy('name')->get() : Parameter::orderBy('name')->get(),
			'groups' => Paramgroup::all(),
			'gid' => $group_id,
			'emptyParameter' => config('app.emptyParameter'),
			'emptyValue' => Item::getEmptyValue(),
		]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Admin/ItemEdit', [
			'item' => Item::with(['categories', 'mainCategory', 'unit'])->findOrFail($id),
			'emptyItem' => Item::getEmptyModel(),
			'categories' => Category::getPlainCatList(),
			'category_id' => 0,
			'units' => Unit::all(),
		]);
    }

    /**
     * Show the form for editing the value of specified resource.
     */
    public function editValue(string $id, string $pid)
    {
        return Inertia::render('Admin/ValueEdit', [
			'value' => Item::findOrFail($id)->parameters()->wherePivot('parameter_id', $pid)->get()->first()->pivot,
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, string $id)
    {
		$item = Item::findOrFail($id);
		$item->unit_id = $request->input('unit_id') ?? null;
		$item->name = $request->input('name');
		$item->like = $request->input('like');
		$item->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$item->description = $request->input('description') ?? null;
		//$item->images = $request->input('images') ?? null;
		$item->save();
		$item->updateCategories($request->input('categories'));
    }

    /**
     * Update the item parameters in storage.
     */
    public function updateParams(UpdateItemParamRequest $request, string $id)
    {
		Item::with(['parameters' => function (Builder $query) {
			$query->leftJoin('paramgroups', 'paramgroups.id', '=', 'parameters.paramgroup_id')->orderByRaw('ISNULL(paramgroups.order), paramgroups.order, parameters.order');
		}])->findOrFail($id)->updateParameters($request->input('parameters'));
    }

    /**
     * Update the specified parameter value in storage.
     */
    public function updateValue(UpdateValueRequest $request)
    {
		Item::findOrFail($request->input('item_id'))->parameters()->updateExistingPivot($request->input('parameter_id'), [
			'value' => $request->input('value') ?? null,
		]);
    }

    /**
     * Remove the specified resource`s image from storage.
     */
    public function storeImage(StoreImageRequest $request)
    {
		$image = $request->file('image');
		$itemId = $request->input('item_id');
		$item = Item::findOrFail( $itemId );
		$images = $item->images ? json_decode( $item->images ) : [];
		$filename = $item->newImageFileName( explode('.', $image->getClientOriginalName())[1] );
		if( !$filename ) return false;
		$file = $item->imageResize( $request->file('image')->getRealPath(), $request->file('image')->getClientMimeType(), $filename );
		if( !$file ) return false;
		array_push($images, $filename);
		$item->images = json_encode($images);
		$item->save();
		return response()->json( $images );
    }

    /**
     * Remove the specified resource`s image from storage.
     */
    public function deleteImage(DeleteImageRequest $request)
    {
		$filename = $request->input('filename');
		$images = false;
		if ($filename) {
			$imageParams = Item::parseImageFileName($filename);
			if ( $imageParams ) {
				$item = Item::findOrFail( $imageParams['item_id'] );
				if ( $item ) {
					if( $item->images ) $images = json_decode( $item->images );
					$item->deleteImage( $filename );
					$item->save();
				}
			}
		}
		return response()->json( $images );
    }
}
