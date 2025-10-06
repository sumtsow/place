<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Requests\UpdatePropositionRequest;
use App\Http\Requests\UpdatePropositionItemsRequest;
use App\Http\Requests\UpdatePropositionStateRequest;
use App\Models\Distributor;
use App\Models\DistributorItem;
use App\Models\Item;
use App\Models\Order;
use App\Models\Proposition;

class PropositionController
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $order_id)
    {
        return Inertia::render('Admin/PropositionsList', [
			'order' => fn () => Order::with(['customer', 'customer.user', 'propositions', 'propositions.distributorItem', 'propositions.distributorItem.distributor', 'propositions.distributorItem.item'])->findOrFail($order_id),
			'currentProposition' => Proposition::getEmptyModel(),
			'propositions' => DistributorItem::with(['item', 'distributor'])->get(),
			'distributors' => Distributor::orderBy('name')->get(),
			'items' => Item::orderBy('name')->get(),
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
    public function store(UpdatePropositionRequest $request)
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
        return Inertia::render('Admin/PropositionEdit', [
			'currentProposition' => Proposition::with(['order', 'distributorItem', 'distributorItem.distributor', 'distributorItem.item'])->findOrFail($id),
			'distributors' => Distributor::orderBy('name')->get(),
			'emptyProposition' => Proposition::getEmptyModel(),
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropositionRequest $request)
    {
		$proposition = Proposition::findOrFail( $request->input('id') );
		$proposition->count = intval( $request->input('count') );
		$proposition->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$proposition->distributor_item_id = intval( $request->input('distributor_item_id') );
		$proposition->save();
    }

    /**
     * Update the specified resource`s sates in storage.
     */
    public function updateState(UpdatePropositionStateRequest $request)
    {
        $proposition = Proposition::findOrFail( $request->input('id') );
		$proposition->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$proposition->save();
    }

    /**
     * Update the specified resource`s items in storage.
     */
    public function updateItems(UpdatePropositionItemsRequest $request, string $order_id)
    {
		$propCollection = collect();
		foreach($request->input('propositions') as $proposition) {
			if( !( $proposition['distributor_item_id'] && $order_id ) ) continue;
			$propObj = Proposition::firstOrNew([
				'order_id' => $order_id,
				'distributor_item_id' => $proposition['distributor_item_id'],
			]);
			if ( $propObj->id ) continue;
			$propObj->count = $proposition['count'];
			$propObj->is_enabled = false;
			$propCollection->push($propObj);
		}
		$order = Order::findOrFail( $order_id );
		$order->propositions()->saveMany($propCollection);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
