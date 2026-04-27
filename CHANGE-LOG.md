# Changelog

Semua perubahan penting pada proyek ini akan didokumentasikan pada file ini.
Format berdasarkan pedoman [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [2026-04-25] - Environment, Auth & Routing Refactor

### 🚀 Added (Fitur/Penambahan Baru)
- **Auth Backdoor**: Menambahkan form "Login Manual (Admin)" di halaman login (`resources/views/livewire/auth/login.blade.php`) untuk mempermudah akses (bypass) ke dalam sistem pada mode lokal tanpa mewajibkan Google OAuth. Akses default: `admin@lppm.com` / `password`. --> `127.000:8000/admin/login`
- **Production Environment Blueprint**: Membuat template konfigurasi `.env.production` sebagai panduan/referensi aman bagi tim terkait standarisasi variabel saat aplikasi rilis ke domain utama (contoh: `layanan-lppm.unsap.ac.id`).
- **Seeder Initialization**: Mengeksekusi dan mendaftarkan data awal (roles/permissions seperti `dosen`, `reviewer`, `super-admin`) beserta data *master lookup* untuk aplikasi surat, guna meminimalisir error "Role Not Found" saat registrasi SSO.

### 🔄 Changed (Perubahan Sistem/Alur)
- **Arsitektur Routing (PENTING)**: Mengubah konsep *Subdomain Routing* (`hki.domain.com`, `surat.domain.com`) menjadi **Prefix Path Routing** (`/hki`, `/surat`, `/buku`) pada file `routes/web.php`.
  - *Catatan untuk Developer*: Hal ini dilakukan sebagai proses *best practice* untuk menghindari *bug* dis-sinkronisasi *cookie session* antar-subdomain, serta sangat mempermudah manajemen SSL, cPanel, dan routing DNS di tingkat server (kini cukup menyediakan 1 domain saja).
- **Google OAuth Variables**: Menyesuaikan variabel `.env` pada *callback* Google menjadi `GOOGLE_REDIRECT_URL` agar terbaca dan cocok dengan rujukan parameter di `config/services.php`.

### 🐛 Fixed (Perbaikan Bug/Error)
- **Database Migration Error**: Memperbaiki duplikasi *schema* pada file migrasi `2026_01_02_004400_ltr-work-institution.php` yang sebelumnya menciptakan foreign-key constraint tak berujung (terselip tabel `book_authors`). Telah disesuaikan menjadi *schema* yang benar untuk tabel `ltr_units`.
- **Missing Session Storage**: Memperbaiki error `Failed to open stream` saat menyimpan data otentikasi login, dengan cara membuat struktur folder framework yang esensial secara manual (`storage/framework/sessions`, `views`, `cache`) yang mana strukturnya di-ignore secara default oleh git.
- **Assets Vite 404 Build**: Menginstruksikan build awal NPM modules (`npm install && npm run build`) agar *assets bundler* (Tailwind/Vite) tidak mengakibatkan blank/404 pada render UI Blade.
- **Bypass Login 2FA Error**: Memperbaiki bug `DecryptException: The payload is invalid` saat login manual menggunakan akun reviewer untuk testing (`email-reviewer@unsap.ac.id`). Bug ini disebabkan oleh factory pembentuk *dummy data* yang selama ini mengisi kolom `two_factor_secret` dengan string *plaintext* yang gagal di-decrypt oleh Laravel Fortify.
  - Lakukan seeding ulang ( jalanakan `php artisan db:seed --class=RoleSeeder` atau `me-refresh` database yang diperlukan) dan menggunakan kredensial di atas pada URL /`admin/login`
