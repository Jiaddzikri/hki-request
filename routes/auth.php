<?php

use App\Http\Controllers\Auth\SocialiteController;

Route::prefix('/auth/google')->group(function() {
    Route::get('/', [SocialiteController::class, 'redirect'])->name('auth.google');
    Route::get('/callback', [SocialiteController::class, 'callback']);
});