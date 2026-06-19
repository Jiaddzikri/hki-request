<?php
use App\Models\HKIAuditLog;
use App\Models\HKIProposal;
use Illuminate\Support\Facades\DB;

// Cari proposal yang kita buat sebelumnya (Proposal Spesial)
$proposal = HKIProposal::where('title', 'Proposal Spesial Pengujian Rantai Hash Panjang')->first();

if (!$proposal) {
    // Jika tidak ada, ambil proposal acak yang punya log
    $log = HKIAuditLog::orderBy('id', 'desc')->first();
} else {
    // Ambil log TERAKHIR dari proposal spesial ini (Tip of the Chain)
    $log = HKIAuditLog::where('model_id', $proposal->id)->orderBy('id', 'desc')->first();
}

if (!$log) {
    echo "Tidak ada log yang bisa diserang.\n";
    exit;
}

echo "Memulai Simulasi Serangan: Tip-of-the-Chain Tampering\n";
echo "Target Log ID: {$log->id} (Log paling ujung / terakhir)\n";
echo "Action Asli: {$log->action}\n";
echo "Hash Asli: " . substr($log->current_hash, 0, 15) . "...\n";

// 1. Hacker mengubah data log terakhir
$tamperedAction = "Data Dimanipulasi Hacker!";
$payload = $log->payload;
if (is_array($payload)) {
    $payload['status'] = "REJECTED_BY_HACKER";
    $payload['note'] = "Disetujui secara ilegal melalui database";
    ksort($payload);
}

// 2. Hacker merekayasa ulang current_hash agar lolos pengecekan Entity Chain
$rawString = $log->previous_hash .
    $log->model_type .
    $log->model_id .
    $log->user_id .
    $tamperedAction .
    json_encode($payload) .
    $log->created_at->format('Y-m-d H:i:s');

$tamperedHash = hash('sha256', $rawString);

// 3. Menyimpan manipulasi ke Database
DB::table('hki_audit_logs')->where('id', $log->id)->update([
    'action' => $tamperedAction,
    'payload' => json_encode($payload),
    'current_hash' => $tamperedHash
]);

echo "\n--- SERANGAN BERHASIL DI-EKSEKUSI ---\n";
echo "Action sekarang: {$tamperedAction}\n";
echo "Hash palsu yang direkayasa: " . substr($tamperedHash, 0, 15) . "...\n";
echo "\nRantai Hash entitas ini SECARA LOKAL akan terlihat VALID karena log setelahnya belum ada.\n";
echo "Namun, sistem memiliki pelindung lapis kedua dan ketiga!\n";
