<?php

use App\Http\Controllers\GrantContractController;
use App\Http\Controllers\Hki\CertificateController;
use App\Http\Middleware\EnsureHasSecurityKeys;
use App\Livewire\Auth\SetupSecurity;
use App\Livewire\Letter\LetterDetail;
use App\Livewire\Letter\LetterList;
use App\Livewire\Letter\LetterSubmission;
use App\Livewire\Hki\Dashboard;
use App\Livewire\Hki\Forensic\PublicVerifier;
use App\Livewire\Hki\Proposal\Lists;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
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
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/', \App\Livewire\Portal::class)->name('portal');

        Route::get('/admin/users', \App\Livewire\Admin\UserManagement::class)
            ->middleware('role:super-admin')
            ->name('admin.users');
    });

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

    require __DIR__ . '/auth.php';
});

/*
|--------------------------------------------------------------------------
| 2. APLIKASI HKI (hki.lppm.test)
|--------------------------------------------------------------------------
*/
Route::domain('hki.lppm.com')->middleware(['auth'])->group(function () {

    Route::get('/', Dashboard::class)->name('hki.dashboard');
    Route::get('/list', Lists::class)->name('hki.list');
    Route::get('/proposal/{id}', \App\Livewire\Hki\Proposal\Detail::class)->name('hki.show');
    Route::get('/create', \App\Livewire\Hki\Proposal\Create::class)->name('hki.create');
    Route::get('/setup-security', \App\Livewire\Auth\SetupSecurity::class)
        ->name('setup.security');
    Route::get('/hki/reviewer/inbox', \App\Livewire\Hki\Reviewer\Inbox::class)
        ->name('hki.reviewer.inbox');
    Route::get('/hki/certificate/{id}', [CertificateController::class, 'download'])->name('hki.certificate.download');
    Route::get('/verify-doc/{id}', PublicVerifier::class)->name('public.verifier');
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

    Route::get('/grants/create', LetterSubmission::class)->name('grants.create');
    Route::get('/grants/list', LetterList::class)->name('grants.list');
    Route::get('/grants/{id}', LetterDetail::class)->name('grants.detail');
    Route::get('/grants/{id}/contract', [GrantContractController::class, 'download'])
        ->name('grants.contract');
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
