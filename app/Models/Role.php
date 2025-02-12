<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    /**
     * Get the user that owns the role
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
