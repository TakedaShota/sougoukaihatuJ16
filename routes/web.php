<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
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
| 認証
|--------------------------------------------------------------------------
*/
// 新規登録
Route::get('/register', [RegisterController::class, 'show'])->name('register.form');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// ログイン
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// ログアウト
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ダッシュボード・承認待ち
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user()->fresh();

    if ($user->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->is_approved) {
        return redirect()->route('threads.index');
    }

    return redirect()->route('waiting');
})->middleware('auth')->name('dashboard');

Route::get('/waiting', function () {
    $user = auth()->user()->fresh();

    if ($user->is_approved) {
        return redirect()->route('threads.index');
    }

    return view('auth.waiting');
})->middleware('auth')->name('waiting');

/*
|--------------------------------------------------------------------------
| 管理者
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/pending', [AdminController::class, 'pending'])->name('admin.pending');
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
    Route::get('/admin/logs', [AdminController::class, 'logs'])->name('admin.logs');
});

/*
|--------------------------------------------------------------------------
| 掲示板（スレッド）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ★ create は {thread} より上に置く
    Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');

    // 一覧
    Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');

    // 保存
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');

    // 詳細
    Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

    // 編集・更新（将来用）
    Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
    Route::put('/threads/{thread}', [ThreadController::class, 'update'])->name('threads.update');

    // 削除
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');

    // 興味あり
    Route::post('/threads/{thread}/interest', [ThreadController::class, 'interest'])
        ->name('threads.interest');

    // コメント
    Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])
        ->name('threads.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    // 通報
    Route::post('/reports', [ReportController::class, 'store'])
        ->name('reports.store');
});

/*
|--------------------------------------------------------------------------
| プロフィール
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
