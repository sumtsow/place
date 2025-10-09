<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Post;
use App\Models\User;

class ItemController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
		$isAdmin = Auth::id() ? Auth::user()->can('admin', User::class) : false;
		if ( $isAdmin ) {
			$item = Item::with([
				'parameters' => function (Builder $query) {
					$query->leftJoin('paramgroups', 'paramgroups.id', '=', 'parameters.paramgroup_id')->orderByRaw('ISNULL(paramgroups.order), paramgroups.order, parameters.order');
				},
				'parameters.group',
				'posts',
				'distributors' => function (Builder $query) {
					$query->orderBy('name');
				},
			])->findOrFail($id);
		} else {
			$item = Item::with([
				'parameters.group' => function (Builder $query) {
					$query->orderBy('order');
				},
				'posts' => function (Builder $query) {
					$query->where('is_enabled', 1);
				},
				'posts.comments' => function (Builder $query) {
					$query->where('is_enabled', 1);
				},
				'distributors' => function (Builder $query) {
					$query->where('distributors.is_enabled', 1)->wherePivot('is_enabled', 1);
				},
				])->findOrFail($id);
		}
		foreach($item->posts as $post) {
			$post->load([ 'user' => fn ($query) => $query->select(['id', 'firstname', 'lastname', 'patronymic']) ]);
			foreach($post->comments as $comment) {
				$comment->load([ 'user' => fn ($query) => $query->select(['id', 'firstname', 'lastname', 'patronymic']) ]);
			};
		};
        return Inertia::render('Item', [
			'item' => $item,
			'emptyPost' => Post::getEmptyModel(),
			'emptyComment' => Comment::getEmptyModel(),
			'emptyParamGroup' => config('app.emptyParamGroup'),
			'links' => $item->getCategoryLinks(),
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
