<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --------------------------------------
// プロフィール（閲覧 & 編集）
// --------------------------------------
Route::middleware('auth')->group(function () {

    // プロフィール閲覧ページ
    Route::get('/profile/show', function () {
        return view('profile.show');
    })->name('profile.show');

    // Breeze 標準
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

