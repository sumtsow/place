<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Item;
use App\Models\Parameter;
use App\Models\Unit;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Requests\UpdateItemParamRequest;
use App\Http\Requests\UpdateValueRequest;
use \Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
	 * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
		$items = Item::getList();
		$emptyItem = [
			'unit_id' => 0,
			'name' => '',
			'is_enabled' => 0,
			'description' => '',
			'images' => '',
		];
        return Inertia::render('Admin/ItemsList', [
			'items' => $items,
			'item' => $emptyItem,
			'units' => Unit::all(),
			'categories' => Category::getPlainCatList(),
			'modal' => config('app.modalMode'),
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/ItemEdit', [
			'item' => new Item(),
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
		$item->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$item->description = $request->input('description') ?? null;
		$item->images = $request->input('images') ?? null;
		$result = $item->save();
		$item->updateCategories($request->input('categories'));
		return $result;
    }

    /**
     * Show the specified Item with it`s Parameters.
     */
    public function show(string $id)
    {
		//dd($id); die();
        return Inertia::render('Admin/ItemShow', [
			'item' => Item::with(['parameters'])->findOrFail($id),
			'parameters' => Parameter::all(),
			'modal' => config('app.modalMode'),
		]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Admin/ItemEdit', [
			'item' => Item::with(['categories', 'mainCategory', 'unit'])->findOrFail($id),
			'categories' => Category::getPlainCatList(),
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
		$item->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$item->description = $request->input('description') ?? null;
		$item->images = $request->input('images') ?? null;
		$result = $item->save();
		$item->updateCategories($request->input('categories'));
		return $result;
    }

    /**
     * Update the item parameters in storage.
     */
    public function updateParams(UpdateItemParamRequest $request, string $id)
    {
		return Item::with(['parameters'])->findOrFail($id)->updateParameters($request->input('parameters'));
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
