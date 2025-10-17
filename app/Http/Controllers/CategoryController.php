<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Item;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		return Inertia::render('Home', [
			'categories' => Category::getCatList(),
			'items' => Item::getMainPageItems(),
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
		$category = Category::with(['subcategories', 'subcategories.subcategories', 'items', 'subcategories.items'])->findOrFail($id);
        return Inertia::render('Category', [
			'canLogin' => Route::has('login'),
			'canRegister' => Route::has('register'),
			'category' => $category,
			'links' => $category->getParentLinks(),
		]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
