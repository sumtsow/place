<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Unit;
use App\Http\Requests\UpdateUnitRequest;

class UnitController extends Controller
{
	protected $emptyUnit = [
		'name' => '',
		'type' => 0,
		'is_enabled' => 1,
	];

    /**
     * Display a listing of the resource.
	 * @param \Illuminate\Http\Request $request
     */
    public function index()
    {
        return Inertia::render('Admin/UnitsList', [
			'units' => Unit::paginate( env('ITEMS_PER_PAGE') )->withQueryString(),
			'unit' => $this->emptyUnit,
			'modal' => config('app.modalMode'),
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/UnitEdit', [
			'unit' => $this->emptyUnit,
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateUnitRequest $request)
    {
        $unit = new Unit();
		$unit->name = $request->input('name');
		$unit->type = $request->input('type') ? 1 : 0;
		$unit->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$unit->save();
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
        return Inertia::render('Admin/UnitEdit', [
			'unit' => Unit::findOrFail($id),
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, string $id)
    {
		$unit = Unit::findOrFail($id);
		$unit->name = $request->input('name');
		$unit->type = $request->input('type') ? 1 : 0;
		$unit->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$unit->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
