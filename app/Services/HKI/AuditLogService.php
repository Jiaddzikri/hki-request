<?php

namespace App\Services\HKI;

use App\Models\HKIAuditLog;
use App\Models\HkiSystemState;
use DB;

class AuditLogService
{
    /**
     * Log activity using Entity-Specific hash chaining and update Global State Pointer.
     */
    public function logActivityGlobal(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Get the latest log for this SPECIFIC entity to maintain its isolated chain
            $lastLog = HKIAuditLog::where('model_type', $data['model_type'])
                ->where('model_id', $data['model_id'])
                ->latest('id')
                ->first();

            $previousHash = $lastLog ? $lastLog->current_hash : str_repeat('0', 64);

            // 2. Prepare Payload
            $payload = $data['payload'] ?? [];
            ksort($payload);
            $payloadJson = json_encode($payload);
            $timestamp = now()->format('Y-m-d H:i:s');

            // 3. Calculate Current Hash
            $rawString = $previousHash.
                         $data['model_type'].
                         $data['model_id'].
                         ($data['user_id'] ?? auth()->id()).
                         $data['action'].
                         $payloadJson.
                         $timestamp;
            $currentHash = hash('sha256', $rawString);

            // 4. Create the Log
            $log = HKIAuditLog::create([
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

            // 5. Update Global State Pointer (to detect complete truncation)
            $systemState = HkiSystemState::firstOrCreate(
                ['key' => 'global_audit_state'],
                ['current_global_hash' => str_repeat('0', 64), 'total_logs' => 0]
            );

            $newGlobalHash = hash('sha256', $systemState->current_global_hash.$currentHash);

            $systemState->update([
                'current_global_hash' => $newGlobalHash,
                'total_logs' => $systemState->total_logs + 1,
            ]);

            return $log;
        });
    }

    /**
     * Verify the integrity of the hash chains.
     * Can verify globally or for a specific entity.
     */
    public function verifyChain(?int $modelId = null, ?string $modelType = \App\Models\HKIProposal::class): array
    {
        $query = HKIAuditLog::orderBy('id', 'asc');

        // If an ID is provided, only verify that specific entity's chain
        if ($modelId) {
            $query->where('model_type', $modelType)->where('model_id', $modelId);
        }

        $logs = $query->get();
        $isValid = true;
        $errors = [];

        // Group logs by entity
        $groupedLogs = $logs->groupBy(function ($log) {
            return $log->model_type.'_'.$log->model_id;
        });

        $latestStates = [];

        // 1. Verify Entity-Specific Chains
        foreach ($groupedLogs as $groupKey => $entityLogs) {
            $previousHash = str_repeat('0', 64);

            foreach ($entityLogs as $log) {
                // Check previous_hash link
                if ($log->previous_hash !== $previousHash) {
                    $isValid = false;
                    $errors[] = [
                        'id' => $log->id,
                        'action' => $log->action,
                        'error' => 'Chain broken: expected previous hash '.substr($previousHash, 0, 8).'... but record has '.substr($log->previous_hash, 0, 8).'...',
                    ];
                }

                // Recalculate current_hash
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

                // Track latest state
                $latestStates[$log->model_type][$log->model_id] = [
                    'payload' => $log->payload,
                    'log_id' => $log->id,
                    'action' => $log->action,
                ];
            }
        }

        // 2. Cross-Verification (State Synchronization Check)
        foreach ($latestStates as $modelClass => $models) {
            if (! class_exists($modelClass)) {
                continue;
            }

            foreach ($models as $id => $stateData) {
                $model = $modelClass::find($id);
                $payload = $stateData['payload'] ?? [];

                if (stripos($stateData['action'], 'delete') !== false) {
                    if ($model) {
                        $isValid = false;
                        $errors[] = [
                            'id' => $stateData['log_id'],
                            'action' => $stateData['action'],
                            'error' => "STATE_TAMPERED: Record should be deleted but exists in database ({$modelClass} ID: {$id})",
                        ];
                    }

                    continue;
                }

                if (! $model) {
                    $isValid = false;
                    $errors[] = [
                        'id' => $stateData['log_id'],
                        'action' => $stateData['action'],
                        'error' => "MISSING_DATA: Record missing in database but exists in audit log ({$modelClass} ID: {$id})",
                    ];

                    continue;
                }

                foreach ($payload as $key => $value) {
                    if (array_key_exists($key, $model->getAttributes())) {
                        if ($model->{$key} !== $value && (string) $model->{$key} !== (string) $value) {
                            $isValid = false;
                            $errors[] = [
                                'id' => $stateData['log_id'],
                                'action' => $stateData['action'],
                                'error' => "STATE_TAMPERED: Database mismatch on '{$key}'. Log says '{$value}', DB says '{$model->{$key}}' ({$modelClass} ID: {$id})",
                            ];
                        }
                    }
                }
            }
        }

        // 3. Global State Pointer Check (Only if verifying globally)
        if (! $modelId) {
            $systemState = HkiSystemState::where('key', 'global_audit_state')->first();
            if ($systemState) {
                $calculatedGlobalHash = str_repeat('0', 64);
                // Important: must traverse globally by ID order to recreate global hash
                $allLogs = HKIAuditLog::orderBy('id', 'asc')->get();
                foreach ($allLogs as $log) {
                    $calculatedGlobalHash = hash('sha256', $calculatedGlobalHash.$log->current_hash);
                }

                if ($calculatedGlobalHash !== $systemState->current_global_hash) {
                    $isValid = false;
                    $errors[] = [
                        'id' => 0,
                        'action' => 'SYSTEM_INTEGRITY',
                        'error' => 'GLOBAL_TRUNCATION: The global state pointer does not match the sum of all logs. Logs have been deleted.',
                    ];
                }
            }
        }

        return [
            'is_valid' => $isValid,
            'errors' => $errors,
            'total_logs' => $logs->count(),
            'verified_at' => now()->format('Y-m-d H:i:s'),
        ];
    }
}
