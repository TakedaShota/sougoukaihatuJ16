<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageImage extends Model
{
    protected $fillable = [
        'message_id',
        'image_url',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}

