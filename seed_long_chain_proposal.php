<?php
use App\Models\HKIProposal;
use App\Models\HKIType;
use App\Models\User;
use App\Services\HKI\AuditLogService;
use Illuminate\Support\Str;

$auditLogService = app(AuditLogService::class);
$user = User::first();
$type = HKIType::first();

if (!$user || !$type) {
    echo "Butuh minimal 1 User dan 1 HKIType.\n";
    exit;
}

echo "Membuat 1 Proposal Khusus dengan Rantai Log Panjang...\n";

// 1. Initial Creation
$proposal = HKIProposal::create([
    'user_id' => $user->id,
    'hki_type_id' => $type->id,
    'title' => 'Proposal Spesial Pengujian Rantai Hash Panjang',
    'description' => 'Proposal ini sengaja dibuat dengan banyak riwayat log untuk menguji serangan manipulasi pada log tengah (Intermediate Log Tampering).',
    'status' => 'SUBMITTED',
    'publication_country' => 'ID',
    'publication_city' => 'Sumedang',
    'url_detail' => '-',
    'publication_date' => now()->subDays(10)->format('Y-m-d'),
]);

$actions = [
    ['action' => 'Pengajuan proposal baru', 'status' => 'SUBMITTED', 'note' => 'Pengajuan awal oleh pengusul'],
    ['action' => 'Pembaruan kelengkapan berkas administratif', 'status' => 'SUBMITTED', 'note' => 'Penambahan scan KTP dan NPWP'],
    ['action' => 'Penugasan Reviewer Internal', 'status' => 'SUBMITTED', 'note' => 'Reviewer 1 ditugaskan oleh sistem'],
    ['action' => 'Pemeriksaan awal oleh Reviewer', 'status' => 'SUBMITTED', 'note' => 'Reviewer mulai membaca dokumen'],
    ['action' => 'Reviewer meminta revisi dokumen teknis', 'status' => 'REVISION_REQUIRED', 'note' => 'Harap perbaiki bab metode penelitian'],
    ['action' => 'Pengusul mengirimkan perbaikan revisi', 'status' => 'SUBMITTED', 'note' => 'Revisi bab metode telah diunggah'],
    ['action' => 'Reviewer menyetujui hasil revisi', 'status' => 'REVIEWED', 'note' => 'Revisi sesuai dengan arahan'],
    ['action' => 'Verifikasi oleh Admin Sentra HKI', 'status' => 'REVIEWED', 'note' => 'Seluruh dokumen lengkap dan valid'],
    ['action' => 'Menunggu persetujuan Kepala LPPM', 'status' => 'REVIEWED', 'note' => 'Masuk antrean persetujuan final'],
    ['action' => 'Persetujuan Final (APPROVED)', 'status' => 'APPROVED', 'note' => 'Proposal resmi disetujui untuk didaftarkan ke DJKI']
];

foreach ($actions as $index => $act) {
    // Update proposal state
    $proposal->update(['status' => $act['status']]);
    
    // Log the action
    $auditLogService->logActivityGlobal([
        'model_type' => HKIProposal::class,
        'model_id' => $proposal->id,
        'user_id' => $user->id,
        'action' => $act['action'],
        'payload' => [
            'title' => $proposal->title,
            'status' => $proposal->status,
            'note' => $act['note']
        ],
    ]);
    
    echo "Log " . ($index + 1) . " berhasil ditambahkan: {$act['action']}\n";
    sleep(1); // Jeda 1 detik agar timestamp berbeda-beda sedikit
}

echo "\nSelesai! Proposal Spesial telah dibuat.\n";
echo "ID Proposal: {$proposal->id}\n";
echo "Jumlah Log: 10 Log Beruntun.\n";
