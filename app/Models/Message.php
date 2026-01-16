<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // interest_request_id を許可
    protected $fillable = ['interest_request_id', 'user_id', 'body'];

    // 送信者とのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 申請（マッチング）とのリレーション
    public function interestRequest()
    {
        return $this->belongsTo(InterestRequest::class);
    }
}