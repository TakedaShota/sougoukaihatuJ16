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
| トップ
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('threads.index');
});

/*
|--------------------------------------------------------------------------
| 認証（登録・ログイン）
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'show'])
    ->middleware('guest')
    ->name('register.form');

Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('guest')
    ->name('register.store');

Route::get('/login', [LoginController::class, 'show'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest')
    ->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| 承認待ち（掲示板へは行けない）
|--------------------------------------------------------------------------
*/
Route::get('/waiting', function () {
    return view('auth.waiting');
})
->middleware('auth')
->name('waiting');

/*
|--------------------------------------------------------------------------
| 管理者専用
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/pending', [AdminController::class, 'pending'])
        ->name('admin.pending');

    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])
        ->name('admin.approve');

    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])
        ->name('admin.reject');

    Route::get('/admin/logs', [AdminController::class, 'logs'])
        ->name('admin.logs');
});

/*
|--------------------------------------------------------------------------
| 掲示板（※承認済みユーザーのみ想定）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // スレッド
    Route::get('/threads', [ThreadController::class, 'index'])
        ->name('threads.index');

    Route::get('/threads/create', [ThreadController::class, 'create'])
        ->name('threads.create');

    Route::post('/threads', [ThreadController::class, 'store'])
        ->name('threads.store');

    Route::get('/threads/{thread}', [ThreadController::class, 'show'])
        ->name('threads.show');

    // ★ スレッド削除 ← ★追加
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])
        ->name('threads.destroy');

    // ★ 興味あり
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
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');
});
