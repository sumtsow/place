<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/CategoriesList', [
			'categories' => Category::getCatList(),
			'category' => Category::all()->first(),
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/CategoryEdit', [
			'category' => new Category(),
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
		$category->category_id = $request->input('category_id') ? $request->input('category_id') : null;
		$category->name = $request->input('name');
		$category->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$category->logo = $request->input('logo') ?? null;
		$category->save();
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
        return Inertia::render('Admin/CategoryEdit', [
			'category' => Category::findOrFail($id),
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
		$category = Category::findOrFail($id);
		$category->category_id = $request->input('category_id') ?? null;
		$category->name = $request->input('name');
		$category->is_enabled = $request->input('is_enabled') ? 1 : 0;
		$category->logo = $request->input('logo') ?? null;
		$category->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
