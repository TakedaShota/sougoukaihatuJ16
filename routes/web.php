<?php

use Illuminate\Support\Facades\Route;
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

// 認証が必要なルート
Route::middleware('auth')->group(function () {

    // ダッシュボード
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 掲示板（仮）
    Route::get('/threads', function () {
        return '掲示板（準備中）';
    })->name('threads.index');

    // プロフィール編集
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    // プロフィール更新
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});

// Breeze 認証
require __DIR__.'/auth.php';
