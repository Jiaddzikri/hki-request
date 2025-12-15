<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Request\DecryptPrivateKeyRequest;
use App\Request\LogActivityRequest;
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
      $lastLog = AuditLog::latest('id')->first();

      $previousHash = $lastLog ? $lastLog->current_hash : str_repeat('0', 64);

      ksort($request->payload);
      $payloadJson = json_encode($request->payload);
      $timestamp = now()->toIso8601String();

      $rawString = $previousHash . $request->user->id . $request->action . $payloadJson . $timestamp;
      $currentHash = hash('sha256', $rawString);

      $decryptReq = new DecryptPrivateKeyRequest();
      $decryptReq->pin = $request->pin;
      $decryptReq->privateKeyEncrypted = $request->user->private_key_encrypted;

      $decryptedKey = $this->service->decryptPrivateKey($decryptReq);
      $privateKey = $decryptedKey->decrypted;

      $signature = '';

      $signSuccess = openssl_sign($currentHash, $signature, $privateKey, OPENSSL_ALGO_SHA256);

      if (!$signSuccess) {
        throw new Exception("Gagal menandatangani data forensik.");
      }

      return AuditLog::create([
        'user_id' => $request->user->id,
        'model_type' => $request->modelType,
        'model_id' => $request->modelId,
        'action' => $request->action,
        'payload' => $payloadJson,
        'previous_hash' => $previousHash,
        'current_hash' => $currentHash,
        'digital_signature' => base64_encode($signature),
        'created_at' => $timestamp,
        'updated_at' => $timestamp,
      ]);
    });
  }
}