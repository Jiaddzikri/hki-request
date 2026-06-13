<?php
$auditLogService = app(\App\Services\HKI\AuditLogService::class);
$user = \App\Models\User::first();
$type = \App\Models\HKIType::first();

$proposal = \App\Models\HKIProposal::create([
    'user_id' => $user->id,
    'hki_type_id' => $type->id,
    'title' => 'Proposal Test Timestamp Tampering',
    'status' => 'SUBMITTED',
    'publication_country' => 'ID',
    'publication_city' => 'Kota A',
    'url_detail' => '-',
    'publication_date' => now()->format('Y-m-d'),
]);

$log = $auditLogService->logActivityGlobal([
    'model_type' => \App\Models\HKIProposal::class,
    'model_id' => $proposal->id,
    'user_id' => $user->id,
    'action' => 'Create Test Proposal',
    'payload' => [
        'title' => $proposal->title,
        'status' => $proposal->status,
    ],
]);

echo "Log payload contains created_at? " . (isset($log->payload['created_at']) ? 'Yes' : 'No') . "\n";
echo "Original updated_at: {$proposal->updated_at}\n";

\DB::table('hki_proposals')->where('id', $proposal->id)->update(['updated_at' => '2020-01-01 10:00:00']);

$result = $auditLogService->verifyChain($proposal->id);

if (!$result['is_valid']) {
    echo "TAMPERING DETECTED!\n";
    print_r($result['errors']);
} else {
    echo "TAMPERING NOT DETECTED (STILL VALID)!\n";
}

$proposal->delete(); // This might fail if the chain is broken or if we just want a simple cleanup. Let's force delete on DB to avoid eloquent events.
\DB::table('hki_audit_logs')->where('id', $log->id)->delete();
\DB::table('hki_proposals')->where('id', $proposal->id)->delete();
