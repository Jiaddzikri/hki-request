<?php

use App\Http\Middleware\EnsureHasSecurityKeys;
use App\Livewire\Auth\SetupSecurity;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

/*
|--------------------------------------------------------------------------
| 1. PORTAL UTAMA (lppm.test)
|--------------------------------------------------------------------------
|
*/
Route::domain('lppm.com')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::redirect('settings', 'settings/profile');

        Route::get('settings/profile', Profile::class)->name('profile.edit');
        // Route::get('settings/password', Password::class)->name('user-password.edit');
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

    require __DIR__ . '/auth.php';
});

/*
|--------------------------------------------------------------------------
| 2. APLIKASI HKI (hki.lppm.test)
|--------------------------------------------------------------------------
*/
Route::domain('hki.lppm.com')->middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return "Selamat Datang di Sistem Forensik HKI";
    })->name('hki.dashboard');

    Route::get('/create', function () {
        return "Form Pengajuan HKI";
    })->name('hki.create');

    Route::get('/setup-security', \App\Livewire\Auth\SetupSecurity::class)
        ->name('setup.security');
});

/*
|--------------------------------------------------------------------------
| 3. APLIKASI SURAT TUGAS (surat.lppm.test)
|--------------------------------------------------------------------------
*/
Route::domain('surat.lppm.com')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return "Sistem Surat Tugas";
    })->name('spt.dashboard');
});

/*
|--------------------------------------------------------------------------
| 4. APLIKASI PERPUSTAKAAN (buku.lppm.test)
|--------------------------------------------------------------------------
*/
Route::domain('buku.lppm.com')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return "Sistem Peminjaman Buku";
    })->name('buku.dashboard');
});
