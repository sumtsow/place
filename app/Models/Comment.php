<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
	/**
     * Get the post that contains the comment
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class)->withTimestamps();
    }
}
