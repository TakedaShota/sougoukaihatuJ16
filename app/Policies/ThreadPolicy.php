<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;

class ThreadPolicy
{
    /**
     * 投稿削除可能か
     * ログインユーザーID と 投稿者ID が一致すれば true
     */
    public function delete(User $user, Thread $thread)
    {
        return $user->id === $thread->user_id;
    }
}