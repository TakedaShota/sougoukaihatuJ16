<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'sender_name',
        'message',
    ];

    public function images()
    {
        return $this->hasMany(MessageImage::class);
    }
}

