<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

// ★ 表示用
Route::get('/chat', [ChatController::class, 'index']);

// ★ 送信用
Route::post('/chat/send', [ChatController::class, 'send']);



Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store']);

// トップページ
Route::get('/', function () {
    return view('welcome');
});

// ダッシュボード（ログイン必須）
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// プロフィール関連（ログイン必須）
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * 掲示板（threads）ルート
 * 開発環境ではゲスト投稿を許可
 */
if (app()->environment('local')) {
    // スレッド一覧・詳細・作成・保存
    Route::resource('threads', ThreadController::class)->only([
        'index', 'show', 'create', 'store',
    ]);

    // コメント投稿（ゲスト投稿可能）
    Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])
        ->name('threads.comments.store');

    // コメント編集・削除（既存）
    Route::resource('threads.comments', CommentController::class)
        ->shallow()
        ->only(['update', 'destroy']);

} else {
    // 本番環境はログイン必須
    Route::resource('threads', ThreadController::class)->only(['index', 'show']);

    Route::middleware('auth')->group(function () {
        Route::resource('threads', ThreadController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy']);

        Route::resource('threads.comments', CommentController::class)
            ->shallow()
            ->only(['store', 'update', 'destroy']);
    });
}

require __DIR__.'/auth.php';
