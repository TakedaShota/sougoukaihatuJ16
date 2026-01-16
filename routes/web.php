<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterestRequestController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| トップページ
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
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

// 承認待ち
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
| 掲示板（スレッド・コメント）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
    Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
    Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
    Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
    Route::put('/threads/{thread}', [ThreadController::class, 'update'])->name('threads.update');
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');

    Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])
        ->name('threads.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');
});

/*
|--------------------------------------------------------------------------
| 興味あり・マッチング（スレッド単位）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/threads/{thread}/interest', [InterestRequestController::class, 'store'])
        ->name('threads.interest.store');

    Route::get('/interest/incoming', [InterestRequestController::class, 'incoming'])
        ->name('interest.incoming');

    Route::get('/interest/outgoing', [InterestRequestController::class, 'outgoing'])
        ->name('interest.outgoing');

    Route::post('/interest/{interestRequest}/approve', [InterestRequestController::class, 'approve'])
        ->name('interest.approve');

    Route::post('/interest/{interestRequest}/reject', [InterestRequestController::class, 'reject'])
        ->name('interest.reject');

    Route::get('/matches', [InterestRequestController::class, 'matches'])
        ->name('matches.index');
});

/*
|--------------------------------------------------------------------------
| チャット機能
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // ▼「new-messages」のような具体的なURLを、必ず先に書きます！
    Route::get('/chat/{interest_request}/new-messages', [ChatController::class, 'getNewMessages'])->name('chat.newMessages');

    // ▼ その後に、何でも入る「{interest_request}」を書きます
    Route::get('/chat/{interest_request}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{interest_request}', [ChatController::class, 'store'])->name('chat.store');
});

/*
|--------------------------------------------------------------------------
| プロフィール
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // ▼▼▼ 順番を修正しました（edit/update を先に書く） ▼▼▼
    
    // 1. 先に「特定のURL（edit）」を書く
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // 2. 最後に「何が入るかわからない {user}」を書く
    // これを下にしないと、edit が {user} に吸い込まれてエラーになります
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
});