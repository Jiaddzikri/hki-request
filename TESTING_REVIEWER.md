# Testing Guide - Sistem Review Surat Tugas

## 🧪 Quick Test

### 1. Assign Role Reviewer ke User

```bash
php artisan tinker
```

```php
// Cara 1: Berdasarkan ID
$user = \App\Models\User::find(1);
$user->assignRole('reviewer');

// Cara 2: Berdasarkan Email
$user = \App\Models\User::where('email', 'test@example.com')->first();
$user->assignRole('reviewer');

// Verifikasi
$user->getRoleNames(); // ['reviewer']
$user->hasRole('reviewer'); // true
$user->can('review surat tugas'); // true
```

### 2. Test Flow Complete

#### A. Sebagai User (Pengaju):

1. Login ke `surat.lppm.com`
2. Klik "Buat Surat Tugas" di sidebar
3. Isi form submission
4. Submit → Status: **Pending** 🟡

#### B. Sebagai Reviewer:

1. Login dengan akun yang memiliki role `reviewer`
2. Akses `surat.lppm.com/letter/reviewer`
3. Lihat submission di inbox
4. Klik **"✓ Approve"** atau **"✗ Reject"**
5. Isi catatan review (min 10 karakter)
6. Submit review

#### C. Verifikasi:

1. Kembali ke halaman user (`/letter`)
2. Lihat status berubah:
   - 🟢 **Approved** atau 🔴 **Rejected**
3. Klik ikon 👁 untuk lihat detail review

### 3. Test dengan Database Query

```bash
php artisan tinker
```

```php
// Lihat semua submission
\App\Models\LtrSubmission::with(['user', 'reviewer'])->get();

// Lihat pending submissions
\App\Models\LtrSubmission::where('status', 'pending')->count();

// Lihat yang sudah direview
\App\Models\LtrSubmission::whereNotNull('reviewer_id')->get();

// Lihat submission tertentu dengan detail review
$submission = \App\Models\LtrSubmission::with('reviewer')->find(1);
return [
    'status' => $submission->status,
    'reviewer' => $submission->reviewer->name ?? 'Belum direview',
    'review_notes' => $submission->review_notes,
    'reviewed_at' => $submission->reviewed_at?->format('Y-m-d H:i:s'),
];
```

### 4. Test Authorization

```php
// Test user tanpa role reviewer
$regularUser = \App\Models\User::find(2);
$regularUser->hasRole('reviewer'); // false
$regularUser->can('review surat tugas'); // false

// Test user dengan role reviewer
$reviewer = \App\Models\User::find(1);
$reviewer->hasRole('reviewer'); // true
$reviewer->can('review surat tugas'); // true
$reviewer->can('approve surat tugas'); // true
$reviewer->can('reject surat tugas'); // true
```

### 5. Test Middleware

**Expected Behavior:**

- User **TANPA** role `reviewer` akses `/letter/reviewer` → Redirect dengan error 403
- User **DENGAN** role `reviewer` akses `/letter/reviewer` → Berhasil masuk

```php
// Test di tinker
$user = \App\Models\User::find(1);
auth()->login($user);

// Cek apakah bisa akses route reviewer
auth()->user()->can('review surat tugas'); // true
```

## 🎯 Test Scenarios

### ✅ Happy Path

1. ✓ User create submission → Status: pending
2. ✓ Reviewer approve → Status: approved, reviewer_id filled, review_notes filled
3. ✓ User can view review details
4. ✓ User cannot delete approved submission

### ❌ Edge Cases

1. User tanpa role reviewer akses reviewer inbox → **403 Forbidden**
2. Reviewer submit review tanpa catatan → **Validation error**
3. Reviewer submit catatan < 10 karakter → **Validation error**
4. User delete submission yang sudah approved → **Button tidak muncul**

## 📊 Test Data

### Create Test Submission

```php
\App\Models\LtrSubmission::create([
    'user_id' => 1,
    'category_id' => 1,
    'unit_id' => 1,
    'description' => 'Test submission untuk review',
    'indicators' => 'Test indicators',
    'status' => 'pending',
]);
```

### Create Multiple Test Submissions

```php
for ($i = 1; $i <= 5; $i++) {
    \App\Models\LtrSubmission::create([
        'user_id' => 1,
        'category_id' => 1,
        'unit_id' => 1,
        'description' => "Test submission #$i untuk review",
        'indicators' => "Test indicators #$i",
        'status' => 'pending',
    ]);
}
```

## 🔍 Debugging

### Clear All Caches

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan permission:cache-reset
```

### Check Current User Permissions

```php
auth()->user()->getAllPermissions()->pluck('name'); // Semua permission
auth()->user()->getRoleNames(); // Semua role
```

### Check Submission Status Count

```php
use App\Models\LtrSubmission;

return [
    'total' => LtrSubmission::count(),
    'pending' => LtrSubmission::where('status', 'pending')->count(),
    'approved' => LtrSubmission::where('status', 'approved')->count(),
    'rejected' => LtrSubmission::where('status', 'rejected')->count(),
];
```

## 🚨 Common Issues & Solutions

### Issue: "This action is unauthorized"

**Solution:**

```bash
php artisan tinker
```

```php
$user = auth()->user();
$user->assignRole('reviewer');
```

### Issue: Menu tidak muncul di sidebar

**Solution:**

```bash
php artisan cache:clear
php artisan permission:cache-reset
```

### Issue: Review tidak tersimpan

**Check:**

1. Kolom database review sudah ada? → Run migration
2. Model LtrSubmission sudah update? → Cek fillable array
3. Validation passed? → Cek min 10 karakter

---

**Happy Testing! 🎉**
