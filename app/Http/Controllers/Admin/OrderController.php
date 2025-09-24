<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;

class OrderController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/OrdersList', [
			'orders' => Order::all(),
			'order' => Order::getEmptyModel(),
			'customers' => User::select('id', DB::raw("CONCAT(firstname, ' ', lastname) AS name"))
				->whereHas('roles', function (Builder $query) {
					$query->where('name', '=', 'customer');
				})->get(),
			'statuses' => Arr::map( Item::getEnumValues('orders', 'status'), fn ($item) => [ 'id' => $item, 'name' => $item ] ),
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Order', [
			'order' => new Order(),
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateOrderRequest $request)
    {
        $order = new Order();
		$order->address = $request->input('address') ? $request->input('address') : '';
		$order->customer_id = $request->input('customer_id') ? $request->input('customer_id') : 0;
		$order->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$order->status = $request->input('status') ? $request->input('status') : 'undefined';
		$order->save();
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
        return Inertia::render('Admin/Order', [
			'order' => Order::findOrFail($id),
			'customers' => User::select('id', DB::raw("CONCAT(firstname, ' ', lastname) AS name"))
				->whereHas('roles', function (Builder $query) {
					$query->where('name', '=', 'customer');
				})->get(),
			'statuses' => Arr::map( Item::getEnumValues('orders', 'status'), fn ($item) => [ 'id' => $item, 'name' => $item ] ),
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request)
    {
		if( !$request->input('id') ) return false;
		$order = Order::findOrFail( $request->input('id') );
        $order->address = $request->input('address') ? $request->input('address') : $order->address;
		$order->customer_id = $request->input('customer_id') ? $request->input('customer_id') : $order->customer_id;
		$order->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$order->status = $request->input('status') ? $request->input('status') : $order->status;
		$order->save();
	}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
