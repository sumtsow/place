<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePostRequest;

use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $itemId)
    {
        /*return Inertia::render('Home', [
			'categories' => Category::where('category_id', NULL)->with('subcategories')->get(),
		]);*/
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
    public function store(UpdatePostRequest $request)
    {
        $post= new Post();
		$post->text = $request->input('text') ? $request->input('text') : null;
		$post->item_id = intval($request->input('item_id'));
		$post->user_id = Auth::id();
		$post->is_enabled = 0;
		$post->id = null;
		if ($post->text && $post->item_id && $post->user_id) $post->save();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::findOrFail( intval($id) );
		$post->text = $request->input('text') ? $request->input('text') : null;
		$post->item_id = intval($request->input('item_id'));
		$post->user_id = Auth::id();
		$post->is_enabled = 0;
		$post->id = $id;
		if ($post->id && $post->text && $post->item_id && $post->user_id) $post->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
