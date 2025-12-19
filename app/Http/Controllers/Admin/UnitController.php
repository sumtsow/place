<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Unit;
use App\Http\Requests\UpdateUnitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
	 * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
		$sort = Unit::validSortField( $request->sort );
		$order = Unit::validOrder( $request->order );
		$unitTypes = config('app.unitType');
		$types = Arr::map($unitTypes, function (string $type, int $key) {
			return [ 'id' => $key, 'name' => $type, ];
		});
        return Inertia::render('Admin/UnitsList', [
			'units' => Unit::orderBy($sort, $order)->paginate( config('app.itemsPerPage') )->withQueryString(),
			'unit' => Unit::getEmptyModel(),
			'types' => $types,
			'unitTypes' => $unitTypes,
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/UnitEdit', [
			'unit' => Unit::getEmptyModel(),
			'types' => $types = Arr::map(config('app.unitType'), function (string $type, int $key) {
				return [ 'id' => $key, 'name' => $type, ];
			}),
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
			'types' => Arr::map(config('app.unitType'), function (string $type, int $key) {
				return [ 'id' => $key, 'name' => $type, ];
			}),
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
