<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| トップページ
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('threads.index');
});

/*
|--------------------------------------------------------------------------
| ダッシュボード（ログイン必須）
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| プロフィール（ログイン必須）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| スレッド
|--------------------------------------------------------------------------
*/

// ★ 作成画面（必ず {thread} より上）
Route::get('/threads/create', [ThreadController::class, 'create'])
    ->name('threads.create');

// 一覧
Route::get('/threads', [ThreadController::class, 'index'])
    ->name('threads.index');

// 保存
Route::post('/threads', [ThreadController::class, 'store'])
    ->name('threads.store');

// 詳細
Route::get('/threads/{thread}', [ThreadController::class, 'show'])
    ->name('threads.show');

// 削除（開発中：誰でもOK）
Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])
    ->name('threads.destroy');

// 興味ありボタン
Route::post('/threads/{thread}/interest', [ThreadController::class, 'interest'])
    ->name('threads.interest');

/*
|--------------------------------------------------------------------------
| コメント
|--------------------------------------------------------------------------
*/
Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])
    ->name('threads.comments.store');

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->name('comments.destroy');

/*
|--------------------------------------------------------------------------
| 通報
|--------------------------------------------------------------------------
*/
Route::post('/reports', [ReportController::class, 'store'])
    ->name('reports.store');

require __DIR__.'/auth.php';
