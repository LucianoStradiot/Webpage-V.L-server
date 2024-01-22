<?php

use App\Http\Controllers\Api\Authentication;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [Authentication::class, 'logout']);
});

Route::post('/signup', [Authentication::class, 'signupSuperAdmin']);
Route::post('/login', [Authentication::class, 'login']);
Route::post('/password/forgot', [Authentication::class, 'forgotPassword']);
Route::post('/password/reset', [Authentication::class, 'resetPassword']);
Route::get('/verify-token/{token}', [Authentication::class, 'verifyResetToken']);