<?php

use App\Http\Controllers\GrantContractController;
use App\Http\Controllers\Hki\CertificateController;
use App\Http\Middleware\EnsureHasSecurityKeys;
use App\Livewire\Auth\SetupSecurity;
use App\Livewire\Letter\Create;
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

    Route::middleware(['role:super-admin', 'security-keys'])->group(function () {
      Route::get('/admin/users', \App\Livewire\Admin\UserManagement::class)->name('admin.users');
      Route::get('/admin/roles', \App\Livewire\Admin\RoleManagement::class)->name('admin.roles');
    });
  });

  Route::middleware(['auth', 'security-keys'])->group(function () {
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

  Route::middleware(['auth', 'security-keys'])->group(function () {

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
Route::domain('hki.lppm.com')->middleware(['auth', 'security-keys'])->group(function () {

  Route::get('/', Dashboard::class)->name('hki.dashboard');
  Route::get('/list', Lists::class)->name('hki.list');
  Route::get('/proposal/{id}', \App\Livewire\Hki\Proposal\Detail::class)->name('hki.show');
  Route::get('/create', \App\Livewire\Hki\Proposal\Create::class)->name('hki.create');
  Route::get('/setup-security', SetupSecurity::class)
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
Route::domain('surat.lppm.com')->middleware(['auth', 'security-keys'])->group(function () {
  Route::get('/', function () {
    return "Sistem Surat Tugas";
  })->name('spt.dashboard');

  Route::get('/letter', \App\Livewire\Letter\Index::class)->name('letter.index');
  Route::get('/letter/create', Create::class)->name('letter.create');

  // Reviewer routes - only accessible by users with 'reviewer' or 'super-admin' role
  Route::middleware(['role:reviewer|super-admin'])->group(function () {
    Route::get('/letter/reviewer', \App\Livewire\Letter\ReviewerInbox::class)->name('letter.reviewer');
  });

});

/*
|--------------------------------------------------------------------------
| 4. APLIKASI PERPUSTAKAAN (buku.lppm.test)
|--------------------------------------------------------------------------
*/
Route::domain('buku.lppm.com')->middleware(['auth', 'security-keys'])->group(function () {
  Route::get('/', \App\Livewire\Book\Index::class)->name('book.index');
  Route::get('/create', \App\Livewire\Book\Create::class)->name('book.create');

  // Reviewer routes - only accessible by users with 'reviewer' or 'super-admin' role
  // PENTING: Letakkan sebelum route /{id} agar tidak tertangkap sebagai parameter
  Route::middleware(['role:reviewer|super-admin'])->group(function () {
    Route::get('/reviewer', \App\Livewire\Book\ReviewerIndex::class)->name('book.reviewer.index');
    Route::get('/reviewer/{id}', \App\Livewire\Book\ReviewerDetail::class)->name('book.reviewer.detail');
  });

  // Route detail dengan parameter {id} - letakkan paling bawah
  Route::get('/{id}', \App\Livewire\Book\Detail::class)->name('book.detail');
});
