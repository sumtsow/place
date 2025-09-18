<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $itemId)
    {
		$posts = Post::where('item_id', $itemId)->with([
			'comments',
			'comments.post',
			'user' => fn ($query) => $query->select(['id', 'firstname', 'lastname', 'patronymic']),
			'comments.user' => fn ($query) => $query->select(['id', 'firstname', 'lastname', 'patronymic']),
		])->get();
        return Inertia::render('Admin/PostsList', [
			'posts' => $posts,
			'emptyPost' => Post::getEmptyModel(),
			'emptyComment' => Comment::getEmptyModel(),
			'links' => Item::findOrFail($itemId)->getCategoryLinks(),
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
    public function store(UpdatePostRequest $request)
    {
        $post= new Post();
		$post->text = $request->input('text') ? $request->input('text') : null;
		$post->item_id = intval($request->input('item_id'));
		$post->user_id = Auth::id();
		$post->is_enabled = Auth::user()->can('admin', User::class) ? 1 : 0;
		$post->id = null;
		if ($post->text && $post->item_id && $post->user_id) $post->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Admin/Post', [
			'post' => Post::with([
				'comments',
				'user' => fn ($query) => $query->select(['id', 'firstname', 'lastname', 'patronymic']),
				'comments.user' => fn ($query) => $query->select(['id', 'firstname', 'lastname', 'patronymic']),
			])->findOrFail($id),
			'isComment' => false,
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
    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::findOrFail( intval($id) );
		$post->text = $request->input('text') ? $request->input('text') : $post->text;
		$item_id = intval($request->input('item_id'));
		if ($item_id) $post->item_id = $item_id;
		$post->is_enabled = $request->input('is_enabled') ? 1 : 0;
		if ($id && $post->text && $post->item_id && $post->user_id) {
			$post->save();
		}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
