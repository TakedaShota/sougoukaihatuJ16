<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 一括代入可能
     */
    protected $fillable = [
        'name',
        'phone',
        'room_number',
        'password',
        'interests',
        'avatar',
        'is_admin',
        'is_approved',
    ];

    /**
     * JSONに含めない
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * 型キャスト（←ここ超重要）
     */
    protected $casts = [
        'is_admin'    => 'boolean',
        'is_approved' => 'boolean',
        'interests'   => 'array',
    ];

    public function interestedThreads()
    {
        return $this->belongsToMany(Thread::class, 'thread_user_interest')
                    ->withTimestamps();
    }
}
