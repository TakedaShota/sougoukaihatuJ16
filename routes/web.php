<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

// トップページ
Route::get('/', function () {
    return view('welcome');
});

// 新規登録
Route::get('/register', [RegisterController::class, 'show'])->name('register.form');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// ログイン
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// ログアウト
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ダッシュボード
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

// 承認待ち
Route::get('/waiting', function () {
    $user = auth()->user()->fresh();

    if ($user->is_approved) {
        return redirect()->route('threads.index');
    }

    return view('auth.waiting');
})->middleware('auth')->name('waiting');

// 管理者ルート
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/pending', [AdminController::class, 'pending'])->name('admin.pending');
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
    Route::get('/admin/logs', [AdminController::class, 'logs'])->name('admin.logs');
});

// 掲示板（スレッド + コメント）
Route::middleware('auth')->group(function () {
    Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
    Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
    Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
    Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
    Route::put('/threads/{thread}', [ThreadController::class, 'update'])->name('threads.update');
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');

    // コメント
    Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])->name('threads.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// プロフィール編集
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
