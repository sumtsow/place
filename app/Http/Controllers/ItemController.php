<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;

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
		$item = Item::with(['parameters', 'posts'])->findOrFail($id);
		foreach($item->posts as $post) {
			$post->load([ 'user' => fn ($query) => $query->select(['id', 'firstname', 'lastname', 'patronymic']) ]);
			foreach($post->comments as $comment) {
				$comment->load([ 'user' => fn ($query) => $query->select(['id', 'firstname', 'lastname', 'patronymic']) ]);
			};
		};
        return Inertia::render('Item', [
			'item' => $item,
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
