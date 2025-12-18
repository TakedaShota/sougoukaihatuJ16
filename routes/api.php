<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/check-approved', function (Request $request) {
    $user = $request->user()->fresh();

    return response()->json([
        'approved' => (bool) $user->is_approved,
    ]);
});
