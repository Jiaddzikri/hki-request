<?php

use App\Models\HKIAuditLog;
use App\Models\HKIProposal;
use App\Models\HkiSystemState;
use Illuminate\Support\Facades\DB;

echo "Memulai proses perbaikan ulang (Rebuild & Sync) seluruh sistem...\n";

// 1. Membuka Kunci Proposal
DB::table('hki_proposals')->update([
    'is_integrity_locked' => false,
    'integrity_locked_at' => null
]);
echo "1. Semua kunci integritas proposal (Lockout) telah dibuka.\n";

// 2. Memperbaiki Hash Spesifik per Entitas
$logs = HKIAuditLog::orderBy('id', 'asc')->get();
$groupedLogs = $logs->groupBy(function($log) {
    return $log->model_type . '_' . $log->model_id;
});

echo "2. Menghitung ulang rantai kriptografi (Hash Chain) untuk setiap proposal...\n";
foreach ($groupedLogs as $entityLogs) {
    $previousHash = str_repeat('0', 64);
    foreach ($entityLogs as $log) {
        $payload = $log->payload;
        if (is_array($payload)) {
            ksort($payload);
        }

        $rawString = $previousHash .
            $log->model_type .
            $log->model_id .
            $log->user_id .
            $log->action .
            json_encode($payload) .
            $log->created_at->format('Y-m-d H:i:s');

        $currentHash = hash('sha256', $rawString);

        if ($log->previous_hash !== $previousHash || $log->current_hash !== $currentHash) {
            DB::table('hki_audit_logs')->where('id', $log->id)->update([
                'previous_hash' => $previousHash,
                'current_hash' => $currentHash
            ]);
        }
        $previousHash = $currentHash;
    }
}

// 3. Memperbaiki Global Hash Chain
echo "3. Menghitung ulang Rantai Hash Global (Global State Pointer)...\n";
$allLogs = HKIAuditLog::orderBy('id', 'asc')->get(); 
$calculatedGlobalHash = str_repeat('0', 64);

foreach ($allLogs as $log) {
    $calculatedGlobalHash = hash('sha256', $calculatedGlobalHash . $log->current_hash);
}

$systemState = HkiSystemState::firstOrCreate(
    ['key' => 'global_audit_state'],
    ['total_logs' => 0]
);

$systemState->update([
    'current_global_hash' => $calculatedGlobalHash,
    'total_logs' => $allLogs->count(),
]);

// 4. Memperbaiki Cross-Checker (Memastikan Database Aktual sama dengan Riwayat Payload)
echo "4. Sinkronisasi Cross-Checker (Menyesuaikan Database HKI dengan Log)...\n";
$latestStates = [];
foreach ($allLogs as $log) {
    $previousPayload = $latestStates[$log->model_type][$log->model_id] ?? [];
    $currentPayload = is_array($log->payload) ? $log->payload : [];
    $latestStates[$log->model_type][$log->model_id] = array_merge($previousPayload, $currentPayload);
}

foreach ($latestStates as $modelClass => $models) {
    if (!class_exists($modelClass)) continue;
    foreach ($models as $id => $payload) {
        $model = clone $modelClass::find($id); 
        if ($model) {
            $updateData = [];
            foreach ($payload as $key => $value) {
                if (array_key_exists($key, $model->getAttributes()) && (string)$model->{$key} !== (string)$value) {
                    $updateData[$key] = $value;
                }
            }
            if (!empty($updateData)) {
                DB::table((new $modelClass)->getTable())->where('id', $id)->update($updateData);
            }
        }
    }
}

echo "\nProses Selesai! Sistem kembali 100% Valid dan siap untuk skenario pengujian baru.\n";
