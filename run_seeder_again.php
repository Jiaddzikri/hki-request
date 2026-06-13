<?php
use App\Models\HKIProposal;
use App\Models\HKIAuditLog;
use App\Models\HKIReview;
use App\Models\HKIProposalSignature;
use App\Models\HkiSystemState;
use App\Models\HKIType;
use App\Models\User;
use App\Services\HKI\AuditLogService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

// 1. MENGHAPUS SEMUA DATA LAMA
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
HKIProposalSignature::truncate();
HKIReview::truncate();
if (class_exists(\App\Models\HKIProposalMember::class)) { \App\Models\HKIProposalMember::truncate(); }
if (class_exists(\App\Models\HKIProposalDocument::class)) { \App\Models\HKIProposalDocument::truncate(); }
HKIAuditLog::truncate();
HKIProposal::truncate();
HkiSystemState::where('key', 'global_audit_state')->delete();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

// 2. MEMBUAT DATA REALISTIS
$auditLogService = app(AuditLogService::class);
$users = User::pluck('id')->toArray();
$hkiTypes = HKIType::pluck('id')->toArray();

if (empty($users) || empty($hkiTypes)) {
    echo "Database harus memiliki minimal 1 User dan 1 Jenis HKI.\n";
    exit;
}

$realisticTitles = [
    'Sistem Deteksi Dini Kebakaran Hutan Berbasis IoT dan Machine Learning',
    'Aplikasi Pemantauan Kesehatan Ibu Hamil dan Janin Jarak Jauh',
    'Modul Edukasi Interaktif Berbasis Augmented Reality untuk Pembelajaran Anatomi',
    'Algoritma Optimasi Rute Pengiriman Barang Terintegrasi dengan Sistem ERP',
    'Desain Antarmuka Pengguna Inklusif untuk Penyandang Disabilitas Netra pada Aplikasi Perbankan',
    'Sistem Verifikasi Tanda Tangan Digital Menggunakan Teknologi Blockchain',
    'Pengembangan Alat Penjernih Air Tenaga Surya Portabel untuk Daerah Terpencil',
    'Metode Klasifikasi Kualitas Biji Kopi Menggunakan Deep Learning dan Computer Vision',
    'Aplikasi Peringatan Dini Gempa Bumi Berbasis Jaringan Sensor IoT Warga',
    'Model Pembelajaran Mesin untuk Prediksi Gagal Panen pada Lahan Pertanian Tadah Hujan',
    'Sistem Informasi Geografis Pemetaan Daerah Rawan Longsor Secara Real-Time',
    'Desain Arsitektur Perangkat Lunak Skalabel untuk E-Commerce Berbasis Microservices',
    'Aplikasi Manajemen Limbah Medis Rumah Sakit dengan Pelacakan RFID',
    'Pengembangan Robot Pembersih Panel Surya Otomatis dengan Kendali Cerdas',
    'Metode Enkripsi Data Ringan untuk Perangkat Internet of Things Terbatas Daya',
    'Platform Crowdfunding Terdesentralisasi untuk Pendanaan Usaha Mikro dan Kecil',
    'Sistem Rekomendasi Karir Berbasis Analisis Sentimen dan Pencapaian Akademik',
    'Pengembangan Game Edukasi Sejarah Kemerdekaan Indonesia Berbasis Virtual Reality',
    'Aplikasi Analisis Pola Konsumsi Energi Rumah Tangga Berbasis Smart Meter',
    'Desain Prototipe Kendaraan Listrik Roda Tiga untuk Mobilitas Perkotaan Jarak Dekat'
];

$cities = ['Bandung', 'Jakarta', 'Yogyakarta', 'Surabaya', 'Semarang', 'Malang', 'Denpasar'];

foreach ($realisticTitles as $index => $title) {
    $userId = $users[array_rand($users)];
    $typeId = $hkiTypes[array_rand($hkiTypes)];
    
    $proposal = HKIProposal::create([
        'user_id' => $userId,
        'hki_type_id' => $typeId,
        'title' => $title,
        'description' => 'Proposal Hak Kekayaan Intelektual ini diajukan untuk mematenkan inovasi di bidang teknologi terapan. Karya ini berfokus pada efisiensi sistem dan pengembangan modul yang dapat dimanfaatkan secara luas oleh masyarakat.',
        'status' => 'SUBMITTED',
        'publication_country' => 'ID',
        'publication_city' => $cities[array_rand($cities)],
        'url_detail' => '-',
        'publication_date' => now()->subDays(rand(1, 150))->format('Y-m-d'),
    ]);

    $auditLogService->logActivityGlobal([
        'model_type' => HKIProposal::class,
        'model_id' => $proposal->id,
        'user_id' => $userId,
        'action' => 'Pengajuan proposal baru',
        'payload' => [
            'title' => $proposal->title,
            'hki_type_id' => $proposal->hki_type_id,
            'status' => $proposal->status,
            'publication_city' => $proposal->publication_city
        ],
    ]);
}
echo "Seeder berhasil dijalankan ulang! 20 Proposal realistis kembali tersedia.\n";
