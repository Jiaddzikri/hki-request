<?php

namespace App\Services\HKI;

use App\Models\HKIAuditLog;
use App\Models\HKIProposal;
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

      // Auto-inject timestamps to protect against Time-Tampering Attack
      $modelClass = $data['model_type'] ?? null;
      $modelId = $data['model_id'] ?? null;

      if ($modelClass && $modelId && class_exists($modelClass)) {
          $model = $modelClass::find($modelId);
          if ($model) {
              // Menyimpan riwayat waktu persis seperti di database
              if ($model->created_at && !isset($payload['created_at'])) {
                  $payload['created_at'] = (string) $model->created_at;
              }
              if ($model->updated_at && !isset($payload['updated_at'])) {
                  $payload['updated_at'] = (string) $model->updated_at;
              }
          }
      }

      ksort($payload);
      $payloadJson = json_encode($payload);
      $timestamp = now()->format('Y-m-d H:i:s');

      // 3. Calculate Current Hash
      $rawString = $previousHash .
        $data['model_type'] .
        $data['model_id'] .
        ($data['user_id'] ?? auth()->id()) .
        $data['action'] .
        $payloadJson .
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

      $newGlobalHash = hash('sha256', $systemState->current_global_hash . $currentHash);

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
  public function verifyChain(string|int|null $modelId = null, ?string $modelType = \App\Models\HKIProposal::class): array
  {
    $query = HKIAuditLog::orderBy('id', 'asc');

    if ($modelId) {
      $query->where('model_type', $modelType)->where('model_id', $modelId);
    }

    $logs = $query->get();
    $verificationState = ['is_valid' => true, 'errors' => []];
    $latestStates = [];

    // 0. Deteksi "Complete Deletion Attack" (Penghapusan seluruh log entitas)
    if ($modelId && class_exists($modelType)) {
        $modelExists = $modelType::where('id', $modelId)->exists();
        if ($modelExists && $logs->isEmpty()) {
            $this->appendError(
                $verificationState,
                null,
                "TRUNCATION_ATTACK: Seluruh riwayat Audit Log untuk proposal ini telah terhapus/dihilangkan dari sistem!"
            );
        }
    }

    // 1. Verify Entity-Specific Hash Chaining
    $this->verifyEntityChains($logs, $verificationState, $latestStates);

    // 2. Cross-Verification (Database vs Log State Synchronization)
    $this->verifyStateSynchronization($latestStates, $verificationState);

    // 3. Global State Pointer Check (only for full audits)
    if (!$modelId) {
      $this->verifyGlobalState($verificationState);
    }

    // 4. State Lockout — Kunci akses entitas jika terdeteksi manipulasi
    if ($modelId && $modelType === HKIProposal::class) {
      $this->applyIntegrityLockIfFailed($modelId, $verificationState);
    }

    return [
      'is_valid' => $verificationState['is_valid'],
      'errors' => $verificationState['errors'],
      'total_logs' => $logs->count(),
      'verified_at' => now()->format('Y-m-d H:i:s'),
    ];
  }

  /**
   * 4. State Lockout — Kunci / Buka kunci proposal berdasarkan hasil verifikasi.
   * Dipanggil secara otomatis setelah verifyChain() untuk entitas spesifik.
   */
  private function applyIntegrityLockIfFailed(string|int $modelId, array $verificationState): void
  {
    $proposal = HKIProposal::find($modelId);

    if (!$proposal) {
      return;
    }

    if (!$verificationState['is_valid']) {
      // Kunci proposal karena manipulasi terdeteksi
      $proposal->update([
        'is_integrity_locked' => true,
        'integrity_locked_at' => now(),
      ]);
    } else {
      // Buka kunci jika rantai kembali valid
      $proposal->update([
        'is_integrity_locked' => false,
        'integrity_locked_at' => null,
      ]);
    }
  }

  /**
   * 1. Verifikasi Entity-Specific Hash Chaining.
   * Memastikan setiap log dalam satu entitas terhubung secara berantai dan tidak ada yang dimodifikasi.
   *
   * @param  \Illuminate\Support\Collection  $logs
   * @param  array{is_valid: bool, errors: array<int, array{id: int, action: string, error: string}>}  $state
   * @param  array<string, array<string|int, array{payload: mixed, log_id: int, action: string}>>  $latestStates
   */
  private function verifyEntityChains($logs, array &$state, array &$latestStates): void
  {
    $groupedLogs = $logs->groupBy(fn($log) => $log->model_type . '_' . $log->model_id);

    foreach ($groupedLogs as $entityLogs) {
      $previousHash = str_repeat('0', 64);

      foreach ($entityLogs as $log) {
        if ($log->previous_hash !== $previousHash) {
          $this->appendError(
            $state,
            $log,
            'Chain broken: expected previous hash ' . substr($previousHash, 0, 8) .
            '... but record has ' . substr($log->previous_hash, 0, 8) . '...'
          );
        }

        $payload = $log->payload;
        if (is_array($payload)) {
          ksort($payload);
        }

        $rawString = $log->previous_hash .
          $log->model_type .
          $log->model_id .
          $log->user_id .
          $log->action .
          json_encode($payload) .
          $log->created_at->format('Y-m-d H:i:s');

        $recalculatedHash = hash('sha256', $rawString);

        if ($log->current_hash !== $recalculatedHash) {
          $this->appendError(
            $state,
            $log,
            'Hash mismatch: recalculated ' . substr($recalculatedHash, 0, 8) .
            '... but record has ' . substr($log->current_hash, 0, 8) . '...'
          );
        }

        $previousHash = $log->current_hash;

        $previousPayload = $latestStates[$log->model_type][$log->model_id]['payload'] ?? [];
        $currentPayload = is_array($log->payload) ? $log->payload : [];
        
        $latestStates[$log->model_type][$log->model_id] = [
          'payload' => array_merge($previousPayload, $currentPayload),
          'log_id' => $log->id,
          'action' => $log->action,
        ];
      }
    }
  }

  /**
   * 2. Cross-Verification (Sinkronisasi Database Aktual vs Log).
   * Mendeteksi perubahan langsung pada database yang tidak tercatat di audit log.
   *
   * @param  array<string, array<string|int, array{payload: mixed, log_id: int, action: string}>>  $latestStates
   * @param  array{is_valid: bool, errors: array<int, array{id: int, action: string, error: string}>}  $state
   */
  private function verifyStateSynchronization(array $latestStates, array &$state): void
  {
    foreach ($latestStates as $modelClass => $models) {
      if (!class_exists($modelClass)) {
        continue;
      }

      foreach ($models as $id => $stateData) {
        $model = $modelClass::find($id);
        $isDeletedAction = stripos($stateData['action'], 'delete') !== false;

        if ($isDeletedAction && $model) {
          $this->appendError(
            $state,
            null,
            "STATE_TAMPERED: Record should be deleted but exists in database ({$modelClass} ID: {$id})"
          );

          continue;
        }

        if (!$isDeletedAction && !$model) {
          $this->appendError(
            $state,
            null,
            "MISSING_DATA: Record missing in database but exists in audit log ({$modelClass} ID: {$id})"
          );

          continue;
        }

        if ($model) {
          $payload = $stateData['payload'] ?? [];
          foreach ($payload as $key => $value) {
            if (
              array_key_exists($key, $model->getAttributes()) &&
              (string) $model->{$key} !== (string) $value
            ) {
              $this->appendError(
                $state,
                null,
                "STATE_TAMPERED: Database mismatch on '{$key}'. Log says '{$value}', DB says '{$model->{$key} }' ({$modelClass} ID: {$id})"
              );
            }
          }
        }
      }
    }
  }

  /**
   * 3. Global State Pointer Check (Mitigasi Truncation Attack).
   * Memastikan tidak ada log yang dihapus secara masif dari database.
   *
   * @param  array{is_valid: bool, errors: array<int, array{id: int, action: string, error: string}>}  $state
   */
  private function verifyGlobalState(array &$state): void
  {
    $systemState = HkiSystemState::where('key', 'global_audit_state')->first();

    if (!$systemState) {
      return;
    }

    $calculatedGlobalHash = str_repeat('0', 64);
    $allLogs = HKIAuditLog::orderBy('id', 'asc')->get();

    foreach ($allLogs as $log) {
      $calculatedGlobalHash = hash('sha256', $calculatedGlobalHash . $log->current_hash);
    }

    if ($calculatedGlobalHash !== $systemState->current_global_hash) {
      $this->appendError(
        $state,
        null,
        'GLOBAL_TRUNCATION: The global state pointer does not match the sum of all logs. Logs have been deleted.'
      );
    }
  }

  /**
   * Helper untuk menstandarkan format penambahan error ke state verifikasi.
   *
   * @param  array{is_valid: bool, errors: array<int, array{id: int, action: string, error: string}>}  $state
   */
  private function appendError(array &$state, ?object $log, string $errorMessage): void
  {
    $state['is_valid'] = false;
    $state['errors'][] = [
      'id' => $log ? $log->id : 0,
      'action' => $log ? $log->action : 'SYSTEM_INTEGRITY',
      'error' => $errorMessage,
    ];
  }
}
