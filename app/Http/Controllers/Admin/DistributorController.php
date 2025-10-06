<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Requests\UpdateDistributorRequest;
use App\Models\Distributor;

class DistributorController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/DistributorsList', [
			'distributors' => Distributor::with(['distributorItems', 'distributorItems.item' ])->get(),
			'distributor' => Distributor::getEmptyModel(),
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Distributor', [
			'distributor' => new Distributor(),
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateDistributorRequest $request)
    {
        $distributor = new Distributor();
		$distributor->name = $request->input('name') ? $request->input('name') : '';
		$distributor->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$distributor->url = $request->input('url') ? $request->input('url') : null;
		$distributor->email = $request->input('email') ? $request->input('email') : null;
		$distributor->phone = $request->input('phone') ? $request->input('phone') : null;
		$distributor->like = $request->input('like') ? intval($request->input('like')) : 0;
		$distributor->dislike = $request->input('dislike') ? intval($request->input('dislike')) : 0;
		$distributor->sales = $request->input('sales') ? intval($request->input('sales')) : 0;
		$distributor->save();
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
        return Inertia::render('Admin/Distributor', [
			'distributor' => Distributor::with(['items'])->findOrFail($id),
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDistributorRequest $request, string $id)
    {
		if( !$request->input('name') ) return false;
        $distributor = Distributor::findOrFail( intval($id) );
		$distributor->name = $request->input('name') ? $request->input('name') : '';
		$distributor->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$distributor->url = $request->input('url') ? $request->input('url') : null;
		$distributor->email = $request->input('email') ? $request->input('email') : null;
		$distributor->phone = $request->input('phone') ? $request->input('phone') : null;
		$distributor->like = $request->input('like') ? intval($request->input('like')) : 0;
		$distributor->dislike = $request->input('dislike') ? intval($request->input('dislike')) : 0;
		$distributor->sales = $request->input('sales') ? intval($request->input('sales')) : 0;
		$distributor->save();
	}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
