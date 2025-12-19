<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Paramgroup;
use App\Models\Unit;
use App\Http\Requests\UpdateParamGroupRequest;

class ParamGroupController extends Controller
{
    /**
     * Display a listing of the resource.
	 * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
		$sort = Paramgroup::validSortField( $request->sort );
		$order = Unit::validOrder( $request->order );
        return Inertia::render('Admin/ParamGroupsList', [
			'paramGroups' => Paramgroup::orderBy($sort, $order)->paginate( config('app.itemsPerPage') )->withQueryString(),
			'paramGroup' => Paramgroup::getEmptyModel(),
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/ParamGroupEdit', [
			'paramGroup' => new Paramgroup(),
			'emptyGroup' => Paramgroup::getEmptyModel(),
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateParamGroupRequest $request)
    {
        $paramgroup = new Paramgroup();
		$paramgroup->name = $request->input('name');
		$paramgroup->order = $request->input('order');
		$paramgroup->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$paramgroup->save();
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
        return Inertia::render('Admin/ParamGroupEdit', [
			'paramGroup' => Paramgroup::findOrFail($id),
			'emptyGroup' => Paramgroup::getEmptyModel(),
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParamGroupRequest $request, string $id)
    {
		$paramgroup = Paramgroup::findOrFail($id);
		$paramgroup->name = $request->input('name');
		$paramgroup->order = $request->input('order');
		$paramgroup->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$paramgroup->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
