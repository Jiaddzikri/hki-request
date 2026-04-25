# Changelog - Penambahan Kolom Nomor Surat pada Letter Assignment

**Tanggal**: 17 Januari 2026  
**Fitur**: Kolom Nomor Surat dengan Auto-Generate

---

## 📋 Summary

Menambahkan fitur kolom `letter_number` pada tabel `ltr_assignment_requests` dengan format nomor surat otomatis seperti: **309/A/LPPM-UNSAP/XII/2025**

---

## 🔧 Perubahan yang Dilakukan

### 1. Database Migration

**File**: `database/migrations/2026_01_17_113219_add_letter_number_to_ltr_assignment_requests_table.php`

- Menambahkan kolom `letter_number` (VARCHAR 100, nullable)
- Posisi: setelah kolom `status`
- Format: `{nomor}/A/LPPM-UNSAP/{bulan_romawi}/{tahun}`

```php
$table->string('letter_number', 100)->nullable()->after('status');
```

---

### 2. Model Update

**File**: `app/Models/LtrAssignmentRequest.php`

#### A. Menambahkan ke $fillable

```php
'letter_number',
```

#### B. Method Auto-Generate Nomor Surat

```php
public static function generateLetterNumber(): string
{
    // Get current year and month in Roman numerals
    $year = now()->format('Y');
    $month = self::getRomanMonth(now()->month);

    // Get last number for this month
    $lastLetter = self::whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->whereNotNull('letter_number')
        ->orderBy('created_at', 'desc')
        ->first();

    $number = 1;
    if ($lastLetter && $lastLetter->letter_number) {
        preg_match('/^(\d+)\//', $lastLetter->letter_number, $matches);
        if (isset($matches[1])) {
            $number = intval($matches[1]) + 1;
        }
    }

    return sprintf('%d/A/LPPM-UNSAP/%s/%s', $number, $month, $year);
}
```

#### C. Method Convert Bulan ke Angka Romawi

```php
private static function getRomanMonth(int $month): string
{
    $romans = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
        5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
        9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
    ];

    return $romans[$month] ?? 'I';
}
```

**Logika**:

- Nomor urut di-reset setiap bulan
- Nomor urut auto-increment dari nomor terakhir di bulan yang sama
- Format bulan menggunakan angka Romawi (I-XII)
- Format tahun 4 digit (YYYY)

---

### 3. Livewire Review Component

**File**: `app/Livewire/Letter/Assignment/Review.php`

- Auto-generate nomor surat saat status di-APPROVE
- Hanya generate jika belum ada nomor surat sebelumnya

```php
// Generate letter number if APPROVED and doesn't have one yet
if ($this->decision === 'APPROVED' && empty($this->assignment->letter_number)) {
    $updateData['letter_number'] = LtrAssignmentRequest::generateLetterNumber();
}
```

---

### 4. View Updates

#### A. Detail Assignment

**File**: `resources/views/livewire/letter/assignment/detail.blade.php`

Menampilkan nomor surat di sidebar "Informasi Pengajuan":

```blade
@if($assignment->letter_number)
<div>
    <dt class="text-xs font-medium text-gray-600 uppercase tracking-wider">Nomor Surat</dt>
    <dd class="mt-1 text-sm text-gray-900 font-semibold font-mono">{{ $assignment->letter_number }}</dd>
</div>
@endif
```

#### B. Index/List Assignment

**File**: `resources/views/livewire/letter/assignment/index.blade.php`

Menambahkan kolom "No. Surat" di tabel:

```blade
<th>No. Surat</th>
...
<td>
    @if($assignment->letter_number)
        <div class="text-xs font-mono text-gray-900">{{ $assignment->letter_number }}</div>
    @else
        <span class="text-xs text-gray-400">-</span>
    @endif
</td>
```

#### C. Reviewer Inbox

**File**: `resources/views/livewire/letter/assignment/reviewer-inbox.blade.php`

Menambahkan kolom "No. Surat" di tabel reviewer:

```blade
<th>No. Surat</th>
...
<td>
    @if($assignment->letter_number)
        <div class="text-xs font-mono text-gray-900">{{ $assignment->letter_number }}</div>
    @else
        <span class="text-xs text-gray-400">-</span>
    @endif
</td>
```

#### D. Review Form

**File**: `resources/views/livewire/letter/assignment/review.blade.php`

- Menampilkan informasi bahwa nomor surat akan di-generate otomatis saat approve
- Menampilkan nomor surat yang sudah ada (jika sudah di-generate)

```blade
<span class="text-xs text-gray-500">(Nomor surat akan di-generate otomatis)</span>

@if($assignment->letter_number)
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
    <p class="text-sm font-medium text-blue-900">Nomor Surat Sudah Dibuat</p>
    <p class="text-sm text-blue-700 font-mono mt-1">{{ $assignment->letter_number }}</p>
</div>
@endif
```

---

## 🎯 Cara Kerja

### Flow Proses:

1. **User Submit** → Status: DRAFT/SUBMITTED (letter_number = null)
2. **Reviewer Review** → Pilih keputusan
3. **Jika APPROVED** → Auto-generate nomor surat dengan format:
   - Ambil nomor urut terakhir di bulan ini
   - Increment +1
   - Format: `{nomor}/A/LPPM-UNSAP/{bulan_romawi}/{tahun}`
   - Contoh: `1/A/LPPM-UNSAP/I/2026`, `2/A/LPPM-UNSAP/I/2026`, dst.
4. **Jika REJECTED/REVISION** → Tidak generate nomor surat

### Contoh Format:

```
1/A/LPPM-UNSAP/I/2026      → Januari 2026, nomor urut 1
2/A/LPPM-UNSAP/I/2026      → Januari 2026, nomor urut 2
1/A/LPPM-UNSAP/II/2026     → Februari 2026, nomor urut 1 (reset)
309/A/LPPM-UNSAP/XII/2025  → Desember 2025, nomor urut 309
```

---

## ✅ Testing Checklist

- [x] Migration berhasil dijalankan
- [x] Kolom letter_number tersimpan di database
- [x] Nomor surat auto-generate saat APPROVE
- [x] Format nomor surat sesuai: `{nomor}/A/LPPM-UNSAP/{bulan}/{tahun}`
- [x] Nomor urut increment otomatis per bulan
- [x] Bulan dalam angka Romawi (I-XII)
- [x] Nomor surat ditampilkan di:
  - [x] Detail assignment
  - [x] List assignment (user)
  - [x] Reviewer inbox
  - [x] Review form
- [x] Nomor surat tidak di-generate untuk REJECTED/REVISION
- [x] Nomor surat tidak di-generate ulang jika sudah ada

---

## 📝 Notes

1. **Nullable Field**: Kolom `letter_number` nullable agar tidak error untuk data existing
2. **Auto-Increment Logic**: Nomor di-reset setiap bulan (query berdasarkan year + month)
3. **Prefix "A"**: Bisa disesuaikan jika ada kategori surat lain (A, B, C, dst)
4. **LPPM-UNSAP**: Hardcoded, bisa dibuat dynamic jika ada multiple institusi
5. **Re-Approval**: Jika status berubah dari REJECTED → APPROVED lagi, nomor tidak re-generate (menggunakan nomor lama jika ada)

---

## 🔄 Rollback

Untuk rollback perubahan ini:

```bash
php artisan migrate:rollback --step=1
```

Atau manual hapus kolom:

```sql
ALTER TABLE ltr_assignment_requests DROP COLUMN letter_number;
```

---

## 👤 Author

- Developer: System
- Date: 17 Januari 2026
- Branch: feat/surat-tugas
