<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestRequest extends Model
{
    protected $fillable = [
        'thread_id',
        'from_user_id',
        'to_user_id',
        'status',
    ];

    // どのスレッドへの申請か
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    // 申請した人
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    // 申請を受ける人（投稿者）
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    // ★追加: この申請（マッチ）に紐づくチャットメッセージ一覧
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}