<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Middleware\EnsureHasSecurityKeys;
use App\Livewire\Auth\SetupSecurity;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::prefix('/auth/google')->group(function() {
    Route::get('/', [SocialiteController::class, 'redirect'])->name('auth.google');
    Route::get('/callback', [SocialiteController::class, 'callback']);
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::get('/setup-security', SetupSecurity::class)
    ->middleware(['auth'])
    ->name('setup.security');

    Route::middleware(['auth', EnsureHasSecurityKeys::class])->group(function () {
    
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');
});
