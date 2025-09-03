<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Parameter;
use App\Models\Unit;
use App\Http\Requests\UpdateParameterRequest;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
	 * @param \Illuminate\Http\Request $request
     */
    public function index()
    {
		$emptyParameter = [
			'unit_id' => 0,
			'name' => '',
			'is_enabled' => '0',
		];
        return Inertia::render('Admin/ParametersList', [
			'parameters' => Parameter::with(['unit'])->paginate( env('ITEMS_PER_PAGE') )->withQueryString(),
			'parameter' => $emptyParameter,
			'empty' => config('app.emptyParameter'),
			'units' => Unit::all(),
			'modal' => config('app.modalMode'),
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/ParameterEdit', [
			'parameter' => new Parameter(),
			'units' => Unit::all(),
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateParameterRequest $request)
    {
        $parameter = new Parameter();
		$parameter->unit_id = $request->input('unit_id') ? $request->input('unit_id') : null;
		$parameter->name = $request->input('name');
		$parameter->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$parameter->save();
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
        return Inertia::render('Admin/ParameterEdit', [
			'parameter' => Parameter::with(['unit'])->findOrFail($id),
			'units' => Unit::all(),
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParameterRequest $request, string $id)
    {
		$parameter = Parameter::findOrFail($id);
		$parameter->unit_id = $request->input('unit_id') ? $request->input('unit_id') : null;
		$parameter->name = $request->input('name');
		$parameter->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$parameter->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
