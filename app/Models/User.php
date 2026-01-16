<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 登録・更新可能なカラム
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'room_number',
        'interests',
        'avatar',
        // ▼ 今回のプロフィール編集機能用に追加
        'image',
        'introduction',
        // ▲ 追加ここまで
        'is_admin',
        'is_approved',
    ];

    /**
     * 隠すカラム
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 型キャスト
     */
    protected $casts = [
        'is_admin'    => 'boolean',
        'is_approved' => 'boolean',
        'interests'   => 'array',
    ];
}