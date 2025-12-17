<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// トップページ
Route::get('/', function () {
    return view('welcome');
});

// =====================
// ログイン
// =====================
Route::get('/login', [LoginController::class, 'show'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

// =====================
// ログアウト
// =====================
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// =====================
// ダッシュボード（ログイン + 承認済み）
// =====================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'approved'])
  ->name('dashboard');

// =====================
// 管理者ルート
// =====================
Route::middleware(['auth'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/pending', [AdminController::class, 'pending'])
        ->name('admin.pending');

    Route::get('/admin/logs', [AdminController::class, 'logs'])
        ->name('admin.logs');

    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])
        ->name('admin.approve');

    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])
        ->name('admin.reject');
});

// =====================
// 承認待ち画面
// =====================
Route::get('/waiting', function () {
    return view('auth.waiting');
})->middleware('auth')
  ->name('waiting');

// =====================
// プロフィール（ログイン必須）
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =====================
// 掲示板（ログイン + 承認済み）
// =====================
Route::middleware(['auth', 'approved'])->group(function () {

    Route::get('/threads', [ThreadController::class, 'index'])
        ->name('threads.index');

    Route::get('/threads/create', [ThreadController::class, 'create'])
        ->name('threads.create');

    Route::post('/threads', [ThreadController::class, 'store'])
        ->name('threads.store');

    Route::get('/threads/{thread}', [ThreadController::class, 'show'])
        ->name('threads.show');

    Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])
        ->name('threads.edit');

    Route::patch('/threads/{thread}', [ThreadController::class, 'update'])
        ->name('threads.update');

    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])
        ->name('threads.destroy');
});
