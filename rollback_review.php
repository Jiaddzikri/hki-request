<?php

$proposalId = '019e92b5-c13c-7032-928c-483af7aa8617';

$proposal = \App\Models\HKIProposal::find($proposalId);
if (!$proposal) {
    echo "Proposal not found\n";
    exit;
}

// 1. Ubah status kembali ke SUBMITTED
$proposal->status = 'SUBMITTED';
$proposal->save();

// 2. Hapus data Review
\App\Models\HKIReview::where('hki_proposal_id', $proposalId)->delete();

// 3. Cari Log Audit terkait Review
$log = \App\Models\HKIAuditLog::where('model_id', $proposalId)
    ->where('action', 'like', 'Review:%')
    ->latest('id')
    ->first();

if ($log) {
    // 4. Hapus Signature
    if ($log->digital_signature) {
        \App\Models\HKIProposalSignature::where('hki_proposal_id', $proposalId)
            ->where('signature', $log->digital_signature)
            ->delete();
    }

    $log->delete();
    echo "Audit Log dan Signature terkait Review berhasil dihapus.\n";
} else {
    echo "Tidak ditemukan Log Audit untuk Review.\n";
}

// 5. Rebuild Global Hash Chain
$logs = \App\Models\HKIAuditLog::orderBy('id', 'asc')->get();
$globalHash = str_repeat('0', 64);

foreach ($logs as $l) {
    $globalHash = hash('sha256', $globalHash . $l->current_hash);
}

$state = \App\Models\HkiSystemState::where('key', 'global_audit_state')->first();
if ($state) {
    $state->current_global_hash = $globalHash;
    $state->total_logs = $logs->count();
    $state->save();
}

echo "Proposal berhasil di-reset ke status SUBMITTED dan rantai hash global telah diperbarui!\n";
