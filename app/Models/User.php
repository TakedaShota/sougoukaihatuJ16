<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 一括代入を許可するカラム
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        // プロフィール
        'icon',
        'bio',
        'hobby',
        'age',
    ];

    /**
     * JSON に含めない属性
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 型キャスト
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
