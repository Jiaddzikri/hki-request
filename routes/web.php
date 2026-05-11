<?php

use App\Http\Controllers\Hki\CertificateController;
use App\Livewire\Auth\SetupSecurity;
use App\Livewire\Hki\Forensic\PublicVerifier;
use App\Livewire\Hki\Proposal\Lists;
use App\Livewire\Letter\Create;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. PORTAL UTAMA (lppm.test)
|--------------------------------------------------------------------------
|
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', \App\Livewire\Portal::class)->name('portal');

    Route::middleware(['role:super-admin', 'security-keys'])->group(function () {
        Route::get('/admin/users', \App\Livewire\Admin\UserManagement::class)->name('admin.users');
        Route::get('/admin/roles', \App\Livewire\Admin\RoleManagement::class)->name('admin.roles');
    });

    Route::middleware(['auth', 'security-keys'])->group(function () {
        Route::redirect('settings', 'settings/profile');

        Route::get('settings/profile', Profile::class)->name('profile.edit');
        Route::get('settings/biometrics', \App\Livewire\Settings\Biometrics::class)->name('settings.biometrics');
        Route::get('settings/appearance', Appearance::class)->name('appearance.edit');
    });

    Route::get('/setup-security', SetupSecurity::class)
        ->middleware(['auth'])
        ->name('setup.security');

    Route::get('/recovery', \App\Livewire\Auth\BiometricRecovery::class)
        ->middleware(['auth'])
        ->name('biometric.recovery');

    Route::middleware(['auth', 'security-keys'])->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
        Route::view('profile', 'profile')->name('profile');
    });

    // --- APLIKASI HKI ---
    Route::prefix('hki')->middleware(['auth'])->group(function () {
        Route::get('/', Lists::class)->name('hki.dashboard');
        Route::get('/list', Lists::class)->name('hki.list');
        Route::get('/proposal/{id}', \App\Livewire\Hki\Proposal\DetailSimple::class)->name('hki.show');

        Route::middleware(['security-keys'])->group(function () {
            Route::get('/create', \App\Livewire\Hki\Proposal\Create::class)->name('hki.create');
            Route::get('/reviewer/inbox', \App\Livewire\Hki\Reviewer\Inbox::class)->name('hki.reviewer.inbox');
        });

        Route::get('/certificate/{id}', [CertificateController::class, 'download'])->name('hki.certificate.download');
        Route::get('/verify-doc/{id}', PublicVerifier::class)->name('public.verifier');
    });

    // --- APLIKASI SURAT TUGAS ---
    Route::prefix('surat')->middleware(['auth', 'security-keys'])->group(function () {
        Route::get('/', function () {
            return 'Sistem Surat Tugas';
        })->name('spt.dashboard');

        Route::get('/letter', \App\Livewire\Letter\Index::class)->name('letter.index');
        Route::get('/letter/create', Create::class)->name('letter.create');

        Route::get('/assignment', \App\Livewire\Letter\Assignment\Index::class)->name('letter.assignment.index');
        Route::get('/assignment/create', \App\Livewire\Letter\Assignment\Create::class)->name('letter.assignment.create');

        Route::middleware(['role:reviewer|super-admin'])->group(function () {
            Route::get('/letter/reviewer', \App\Livewire\Letter\ReviewerInbox::class)->name('letter.reviewer');
            Route::get('/assignment/reviewer', \App\Livewire\Letter\Assignment\ReviewerInbox::class)->name('letter.assignment.reviewer.inbox');
            Route::get('/assignment/reviewer/{id}', \App\Livewire\Letter\Assignment\Review::class)->name('letter.assignment.review');
        });

        Route::get('/letter/assignment/download/{id}', [\App\Http\Controllers\LetterAssigmentController::class, 'download'])->name('letter.assignment.download');
        Route::get('/assignment/{id}', \App\Livewire\Letter\Assignment\Detail::class)->name('letter.assignment.detail');
        Route::get('/assignment/{id}/edit', \App\Livewire\Letter\Assignment\Edit::class)->name('letter.assignment.edit');
    });

    // --- APLIKASI PERPUSTAKAAN ---
    Route::prefix('buku')->middleware(['auth', 'security-keys'])->group(function () {
        Route::get('/', \App\Livewire\Book\Index::class)->name('book.index');
        Route::get('/create', \App\Livewire\Book\Create::class)->name('book.create');

        Route::middleware(['role:reviewer|super-admin'])->group(function () {
            Route::get('/reviewer', \App\Livewire\Book\ReviewerIndex::class)->name('book.reviewer.index');
            Route::get('/reviewer/{id}', \App\Livewire\Book\ReviewerDetail::class)->name('book.reviewer.detail');
        });

        Route::get('/{id}', \App\Livewire\Book\Detail::class)->name('book.detail');
    });

});

require __DIR__.'/auth.php';
