<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Thread;
use App\Models\Comment;
use App\Policies\ThreadPolicy;
use App\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * ポリシーの対応表
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Thread::class  => ThreadPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * 認可サービスの登録
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
