<?php

$logs = \App\Models\HKIAuditLog::orderBy('id', 'asc')->get();
$globalHash = str_repeat('0', 64);

$latestStates = [];

foreach ($logs as $log) {
    if ($log->model_type === 'App\Models\HkiProposal') {
        $log->model_type = 'App\Models\HKIProposal';
    }

    $previousHash = str_repeat('0', 64);
    if (isset($latestStates[$log->model_type][$log->model_id])) {
        $previousHash = $latestStates[$log->model_type][$log->model_id]['hash'];
    }

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

    $log->previous_hash = $previousHash;
    $log->current_hash = hash('sha256', $rawString);
    $log->save();

    $latestStates[$log->model_type][$log->model_id] = ['hash' => $log->current_hash];

    $globalHash = hash('sha256', $globalHash . $log->current_hash);
}

$state = \App\Models\HkiSystemState::where('key', 'global_audit_state')->first();
if ($state) {
    $state->current_global_hash = $globalHash;
    $state->save();
}

\App\Models\HKIProposal::query()->update([
    'is_integrity_locked' => false,
    'integrity_locked_at' => null,
]);

echo "Hashes fixed successfully.\n";

