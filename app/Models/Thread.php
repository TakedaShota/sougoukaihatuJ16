<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = [
        'title',
        'body',
        'image',
        'user_id',
        'enable_interest',
        'interest_count',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
