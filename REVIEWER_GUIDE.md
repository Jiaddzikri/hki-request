# Panduan Sistem Review Surat Tugas

## 📋 Deskripsi

Sistem review untuk pengajuan surat tugas yang memungkinkan reviewer untuk menyetujui atau menolak submission.

## 🔑 Role & Permission

### Role yang Tersedia:

- **reviewer**: Dapat melakukan review, approve, dan reject surat tugas
- **super-admin**: Memiliki semua permission termasuk reviewer

### Permissions:

- `review surat tugas`: Akses ke inbox reviewer
- `approve surat tugas`: Menyetujui submission
- `reject surat tugas`: Menolak submission

## 🚀 Cara Setup

### 1. Jalankan Seeder

```bash
php artisan db:seed --class=ReviewerRoleSeeder
```

### 2. Assign Role ke User

```bash
php artisan tinker
```

Kemudian di tinker:

```php
// Cari user yang ingin dijadikan reviewer
$user = User::where('email', 'reviewer@example.com')->first();

// Assign role reviewer
$user->assignRole('reviewer');

// Atau assign role super-admin (punya semua akses)
$user->assignRole('super-admin');

// Cek role user
$user->getRoleNames();
```

## 📱 Cara Menggunakan

### Untuk Reviewer:

1. **Login** dengan akun yang memiliki role `reviewer` atau `super-admin`

2. **Akses Inbox Reviewer**:

   - Masuk ke domain: `surat.lppm.com`
   - Di sidebar, klik **"Inbox Review Surat"** di bawah section "Area Reviewer"
   - Atau akses langsung: `http://surat.lppm.com/letter/reviewer`

3. **Filter & Search**:

   - Gunakan search bar untuk mencari berdasarkan deskripsi atau nama user
   - Filter berdasarkan status: Pending, Approved, Rejected

4. **Review Submission**:

   - Untuk submission dengan status **Pending**:
     - Klik tombol **"✓ Approve"** (hijau) untuk menyetujui
     - Klik tombol **"✗ Reject"** (merah) untuk menolak
   - Isi **Catatan Review** (minimal 10 karakter)
   - Klik **"Submit Review"**

5. **Lihat Detail Submission yang Sudah Direview**:
   - Klik tombol **"👁 Lihat Detail"** (biru) untuk submission yang sudah approved/rejected
   - Akan menampilkan informasi lengkap termasuk catatan review sebelumnya

### Untuk User (Pengaju):

1. **Cek Status Submission**:

   - Login dan akses `http://surat.lppm.com/letter`
   - Lihat kolom "Status" untuk melihat status submission:
     - 🟡 **Pending**: Menunggu review
     - 🟢 **Approved**: Disetujui
     - 🔴 **Rejected**: Ditolak

2. **Lihat Detail Review**:

   - Klik ikon 👁 pada submission
   - Jika sudah direview, akan muncul informasi:
     - Status (Approved/Rejected)
     - Direview oleh siapa
     - Tanggal review
     - Catatan review dari reviewer

3. **Hapus Submission**:
   - Hanya submission dengan status **Pending** yang bisa dihapus
   - Klik tombol 🗑 untuk menghapus

## 🎨 Fitur UI

### Reviewer Inbox:

- ✅ Search & filter submissions
- ✅ Badge status dengan warna (Pending/Approved/Rejected)
- ✅ Modal review dengan form catatan
- ✅ Pagination (10 items per page)
- ✅ Responsive design dengan Tailwind CSS

### User Submission List:

- ✅ Badge status berwarna
- ✅ Info reviewer & tanggal review
- ✅ Conditional delete button (hanya untuk status pending)
- ✅ Detail modal dengan info lengkap

## 🔒 Keamanan

- ✅ Route dilindungi dengan middleware `role:reviewer|super-admin`
- ✅ Authorization check di component level (`authorize('review surat tugas')`)
- ✅ Permission check sebelum approve/reject
- ✅ Validasi form (catatan minimal 10 karakter)

## 📊 Database

### Kolom Baru di `ltr_submissions`:

- `status`: enum('pending', 'approved', 'rejected') default 'pending'
- `reviewer_id`: Foreign key ke users table (nullable)
- `review_notes`: Text catatan review (nullable)
- `reviewed_at`: Timestamp waktu review (nullable)

### Relasi:

```php
// Di Model LtrSubmission
public function reviewer()
{
    return $this->belongsTo(User::class, 'reviewer_id');
}
```

## 🔗 Routes

```php
// Protected by role middleware
Route::middleware(['role:reviewer|super-admin'])->group(function () {
    Route::get('/letter/reviewer', ReviewerInbox::class)->name('letter.reviewer');
});
```

## 💡 Tips

1. **Assign Multiple Roles**:

```php
$user->assignRole(['reviewer', 'other-role']);
```

2. **Check Permission**:

```php
// Di blade
@can('review surat tugas')
    // Show something
@endcan

// Di controller/component
$this->authorize('review surat tugas');
```

3. **Remove Role**:

```php
$user->removeRole('reviewer');
```

## 🐛 Troubleshooting

### Error: "This action is unauthorized"

- Pastikan user sudah di-assign role `reviewer` atau `super-admin`
- Cek dengan: `$user->getRoleNames()`

### Menu "Inbox Review Surat" tidak muncul

- Pastikan user memiliki role `reviewer` atau `super-admin`
- Clear cache: `php artisan cache:clear`
- Clear permission cache: `php artisan permission:cache-reset`

### Submission tidak muncul di inbox

- Pastikan ada submission dengan status `pending`
- Cek filter status tidak menghalangi

## 📝 Contoh Workflow

1. **User** membuat submission surat tugas → Status: Pending
2. **Reviewer** login dan akses inbox reviewer
3. **Reviewer** melihat list submission pending
4. **Reviewer** klik approve/reject, isi catatan review
5. **Sistem** update status, reviewer_id, review_notes, reviewed_at
6. **User** melihat status berubah dan dapat membaca catatan review

---

**Dibuat pada:** 3 Januari 2026  
**Laravel Version:** 12.41.1  
**Package:** spatie/laravel-permission
