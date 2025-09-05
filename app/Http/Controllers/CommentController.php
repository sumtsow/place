<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateCommentRequest;

use App\Models\Comment;

class CommentController extends Controller
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
    public function store(UpdateCommentRequest $request)
    {
        $comment = new Comment;
		$comment->text = $request->input('text') ? $request->input('text') : null;
		$comment->post_id = intval($request->input('post_id'));
		$comment->user_id = Auth::id();
		$comment->is_enabled = 0;
		if ($comment->text && $comment->post_id && $comment->user_id) $comment->save();
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
    public function update(UpdateCommentRequest $request, string $id)
    {
        $comment = Comment::findOrFail( intval($id) );
		$comment->text = $request->input('text') ? $request->input('text') : null;
		$comment->post_id = intval($request->input('post_id'));
		$comment->is_enabled = 0;
		if ($comment->id && $comment->text && $comment->post_id && $comment->user_id) $comment->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
