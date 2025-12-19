<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\Paramgroup;
use App\Models\Unit;
use App\Http\Requests\UpdateParameterRequest;
use App\Http\Requests\UpdateParameterStateRequest;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
	 * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request, string $id = null)
    {
		$sort = Parameter::validSortField( $request->sort );
		$order = Unit::validOrder( $request->order );
		if ($id) {
			$parameters = Parameter::where('paramgroup_id', $id)->with(['unit', 'group'])->orderBy($sort, $order)->paginate( config('app.itemsPerPage') )->withQueryString();
		} else {
			$parameters = Parameter::with(['unit', 'group'])->orderBy($sort, $order)->paginate( config('app.itemsPerPage') )->withQueryString();
		}
        return Inertia::render('Admin/ParametersList', [
			'parameters' => $parameters,
			'parameter' => Parameter::getEmptyModel(),
			'empty' => config('app.emptyParameter'),
			'units' => Unit::orderBy('name')->get(),
			'groups' => Paramgroup::orderBy('order')->get(),
			'groupId' => +$id,
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/ParameterEdit', [
			'parameter' => Parameter::getEmptyModel(),
			'units' => Unit::all(),
			'groups' => Paramgroup::orderBy('order')->get(),
			'emptyParam' => Parameter::getEmptyModel(),
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateParameterRequest $request)
    {
        $parameter = new Parameter();
		$parameter->unit_id = $request->input('unit_id') ? $request->input('unit_id') : null;
		$parameter->paramgroup_id = $request->input('paramgroup_id') ? $request->input('paramgroup_id') : null;
		$parameter->name = $request->input('name');
		$parameter->order = $request->input('order');
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
			'groups' => Paramgroup::orderBy('order')->get(),
			'emptyParam' => Parameter::getEmptyModel(),
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParameterRequest $request)
    {
		$parameter = Parameter::findOrFail($request->input('id'));
		$parameter->unit_id = $request->input('unit_id') ? $request->input('unit_id') : null;
		$parameter->paramgroup_id = $request->input('paramgroup_id') ? $request->input('paramgroup_id') : null;
		$parameter->order = $request->input('order');
		$parameter->name = $request->input('name');
		$parameter->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$parameter->save();
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateState(UpdateParameterStateRequest $request)
    {
		$parameter = Parameter::findOrFail($request->input('id'));
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
