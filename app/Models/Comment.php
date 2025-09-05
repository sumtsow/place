<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{

	//protected $with = ['user'];

	/**
     * Get the post that contains the comment
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class)->withTimestamps();
    }

	/**
     * Get the post that contains the comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
