<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateDistributorItemRequest;
use App\Http\Requests\UpdateDistributorItemStateRequest;
use App\Http\Requests\UpdateDistributorItemsRequest;
use App\Models\Distributor;
use App\Models\DistributorItem;
use App\Models\Item;

class DistributorItemController
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $distributor_id)
    {
        return Inertia::render('Admin/DistributorItems', [
			'distributor' => Distributor::with('distributorItems', 'distributorItems.item')->findOrFail($distributor_id),
			'items' => Item::orderBy('name')->get(),
			'currentDistributorItem' => DistributorItem::getEmptyModel(),
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        return Inertia::render('Admin/DistributorItemEdit', [
			'currentDistributorItem' => DistributorItem::findOrFail($id),
			'emptyDistributorItem' => DistributorItem::getEmptyModel(),
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDistributorItemRequest $request)
    {
		$distributorItem = DistributorItem::findOrFail($request->input('id'));
		$distributorItem->count = $request->input('count');
		$distributorItem->discount = $request->input('discount');
		$distributorItem->delivery = $request->input('delivery');
		$distributorItem->price = $request->input('price');
		$distributorItem->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$distributorItem->save();
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateItems(UpdateDistributorItemsRequest $request)
    {
		$distributor_id = $request->input('distributor_id');
		$items = collect();
		foreach($request->input('items') as $item) {
			if( !( $item['item_id'] && $distributor_id ) ) continue;
			$itemObj = DistributorItem::firstOrNew([
				'distributor_id' => $distributor_id,
				'item_id' => $item['item_id'],
			]);
			if ( $itemObj->id ) continue;
			$itemObj->count = 0;
			$itemObj->price = 0;
			$itemObj->discount = 0;
			$itemObj->delivery = 0;
			$itemObj->is_enabled = false;
			$items->push( $itemObj );
		}
		$distributor = Distributor::findOrFail( $distributor_id );
		$distributor->distributorItems()->saveMany($items);
		
    }

    /**
     * Update the specified resource`s pivot in storage.
     */
    public function updateState(UpdateDistributorItemStateRequest $request)
    {
        $distributorItem = DistributorItem::where('item_id', $request->input('item_id') )->where('distributor_id', $request->input('distributor_id') )->firstOrFail();
		$distributorItem->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$distributorItem->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
