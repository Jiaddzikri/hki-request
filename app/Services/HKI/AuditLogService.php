<?php

namespace App\Services\HKI;

use App\Models\HKIAuditLog;
use DB;

class AuditLogService
{
    /**
     * Log activity with global hash chaining.
     * Supports both PIN-based signatures and Biometric evidence.
     */
    public function logActivityGlobal(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Get the latest log globally to maintain the chain
            $lastLog = HKIAuditLog::latest('id')->first();
            $previousHash = $lastLog ? $lastLog->current_hash : str_repeat('0', 64);

            // 2. Prepare Payload
            $payload = $data['payload'] ?? [];
            ksort($payload);
            $payloadJson = json_encode($payload);
            $timestamp = now()->format('Y-m-d H:i:s');

            // 3. Calculate Current Hash (Include model details to ensure uniqueness)
            $rawString = $previousHash.
                         $data['model_type'].
                         $data['model_id'].
                         ($data['user_id'] ?? auth()->id()).
                         $data['action'].
                         $payloadJson.
                         $timestamp;
            $currentHash = hash('sha256', $rawString);

            // 4. Create the Log
            return HKIAuditLog::create([
                'user_id' => $data['user_id'] ?? auth()->id(),
                'model_type' => $data['model_type'],
                'model_id' => $data['model_id'],
                'action' => $data['action'],
                'payload' => $payload,
                'previous_hash' => $previousHash,
                'current_hash' => $currentHash,
                'digital_signature' => $data['digital_signature'] ?? null,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        });
    }

    /**
     * Verify the integrity of the entire hash chain.
     */
    public function verifyChain(): array
    {
        $logs = HKIAuditLog::orderBy('id', 'asc')->get();
        $isValid = true;
        $errors = [];
        $previousHash = str_repeat('0', 64);

        foreach ($logs as $log) {
            // 1. Check if previous_hash matches the chain
            if ($log->previous_hash !== $previousHash) {
                $isValid = false;
                $errors[] = [
                    'id' => $log->id,
                    'action' => $log->action,
                    'error' => 'Chain broken: expected previous hash '.substr($previousHash, 0, 8).'... but record has '.substr($log->previous_hash, 0, 8).'...',
                ];
            }

            // 2. Recalculate current_hash
            $payload = $log->payload;
            if (is_array($payload)) {
                ksort($payload);
            }
            $payloadJson = json_encode($payload);

            $timestamp = $log->created_at->format('Y-m-d H:i:s');
            $rawString = $log->previous_hash.
                         $log->model_type.
                         $log->model_id.
                         $log->user_id.
                         $log->action.
                         $payloadJson.
                         $timestamp;
            $recalculatedHash = hash('sha256', $rawString);

            if ($log->current_hash !== $recalculatedHash) {
                $isValid = false;
                $errors[] = [
                    'id' => $log->id,
                    'action' => $log->action,
                    'error' => 'Hash mismatch: recalculated '.substr($recalculatedHash, 0, 8).'... but record has '.substr($log->current_hash, 0, 8).'...',
                ];
            }

            $previousHash = $log->current_hash;
        }

        return [
            'is_valid' => $isValid,
            'errors' => $errors,
            'total_logs' => $logs->count(),
            'verified_at' => now()->format('Y-m-d H:i:s'),
        ];
    }
}
