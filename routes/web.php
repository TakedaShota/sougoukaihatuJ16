<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ThreadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================
// トップページ
// =====================
Route::get('/', function () {
    return view('welcome');
});

// =====================
// 登録
// =====================
Route::get('/register', [RegisterController::class, 'showForm'])
    ->name('register.form');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register');

// =====================
// ログイン
// =====================
Route::get('/login', [LoginController::class, 'show'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

// =====================
// 一般ユーザー画面
// （ログイン + 承認済み）
// =====================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'approved'])
  ->name('dashboard');

// =====================
// 管理者ルート（★開発用：制限なし★）
// ※ 本番では必ず auth/admin を付ける
// =====================
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

// =====================
// 承認待ち画面
// =====================
Route::get('/waiting', function () {
    return view('auth.waiting');
})->middleware('auth')
  ->name('waiting');

// =====================
// 掲示板（ログイン + 承認済み）
// =====================
Route::middleware(['auth', 'approved'])->group(function () {

    // 掲示板一覧
    Route::get('/threads', [ThreadController::class, 'index'])
        ->name('threads.index');

    // スレッド作成画面
    Route::get('/threads/create', [ThreadController::class, 'create'])
        ->name('threads.create');

    // スレッド保存
    Route::post('/threads', [ThreadController::class, 'store'])
        ->name('threads.store');

    // （あとで）スレッド詳細
    // Route::get('/threads/{thread}', [ThreadController::class, 'show'])
    //     ->name('threads.show');
});

// =====================
// ログアウト
// =====================
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');
