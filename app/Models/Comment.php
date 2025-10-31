<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
	protected $casts = [
		'is_enabled' => 'boolean',
	];

	private static $emptyModel = [
		'id' => 0,
		'text' => '',
		'post_id' => 0,
		'user_id' => 0,
		'is_enabled' => false,
	];

	/**
     * Get the post that contains the comment
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

	/**
     * Get the post that contains the comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

	public static function getEmptyModel() {
		return self::$emptyModel;
	}
}
