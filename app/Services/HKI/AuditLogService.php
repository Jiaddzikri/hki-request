<?php

namespace App\Services\HKI;

use App\Models\HkiAuditLog;
use App\Request\HKI\DecryptPrivateKeyRequest;
use App\Request\HKI\LogActivityRequest;
use App\Models\AuditLog;

use DB;
use Exception;

class AuditLogService
{
  public function __construct(private KeyManagementService $service)
  {

  }

  public function logActivity(LogActivityRequest $request)
  {
    return DB::transaction(function () use ($request) {
      $lastLog = HKIAuditLog::latest('id')->first();

      $modelClass = get_class($request->modelType);

      $previousHash = $lastLog ? $lastLog->current_hash : str_repeat('0', 64);

      ksort($request->payload);
      $payloadJson = json_encode($request->payload);
      $timestamp = now()->format('Y-m-d H:i:s');

      $rawString = $previousHash . $request->user->id . $request->action . $payloadJson . $timestamp;
      $currentHash = hash('sha256', $rawString);

      $decryptReq = new DecryptPrivateKeyRequest();
      $decryptReq->pin = $request->pin;
      $decryptReq->encryptedKey = $request->user->private_key_encrypted;

      $decryptedKey = $this->service->decryptPrivateKey($decryptReq);
      $privateKey = $decryptedKey->decrypted;

      $signature = '';

      $signSuccess = openssl_sign($currentHash, $signature, $privateKey, OPENSSL_ALGO_SHA256);

      if (!$signSuccess) {
        throw new Exception("Gagal menandatangani data forensik.");
      }

      return HkiAuditLog::create([
        'user_id' => $request->user->id,
        'model_type' => $modelClass,
        'model_id' => $request->modelId,
        'action' => $request->action,
        'payload' => $request->payload,
        'previous_hash' => $previousHash,
        'current_hash' => $currentHash,
        'digital_signature' => base64_encode($signature),
        'created_at' => $timestamp,
        'updated_at' => $timestamp,
      ]);
    });
  }
}