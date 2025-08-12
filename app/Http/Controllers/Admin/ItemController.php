<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/ItemsList', [
			'items' => Item::getList(),
			'item' => Item::all()->first(),
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
    public function store(StoreItemRequest $request)
    {
        $item = new Item();
		$item->unit_id = $request->input('unit_id') ? $request->input('unit_id') : null;
		$item->name = $request->input('name');
		$item->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$item->description = $request->input('description') ?? null;
		$item->save();
		$item->updateCategories($request->input('categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Admin/ItemEdit', [
			'item' => Item::findOrFail($id),
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
		$item->save();
		$item->updateCategories($request->input('categories'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
