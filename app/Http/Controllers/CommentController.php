<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
		$comment->is_enabled  = Auth::user()->can('admin', User::class) ? 1 : 0;
		if ($comment->text && $comment->post_id && $comment->user_id) $comment->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
		return Inertia::render('Admin/Comment', [
			'editedPost' => Comment::with([
				'post',
				'user' => fn ($query) => $query->select(['id', 'firstname', 'lastname', 'patronymic']),
			])->findOrFail($id),
			'isComment' => true,
			'emptyComment' => Comment::getEmptyModel(),
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
    public function update(UpdateCommentRequest $request, string $id)
    {
        $comment = Comment::findOrFail( intval($id) );
		$comment->text = $request->input('text') ? $request->input('text') : $comment->text;
		$post_id = intval($request->input('post_id'));
		if ($post_id) $comment->post_id = $post_id;
		$comment->is_enabled = $request->input('is_enabled') ? 1 : 0;
		if ($id && $comment->text && $comment->post_id && $comment->user_id) $comment->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
