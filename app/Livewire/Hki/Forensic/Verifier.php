<?php

namespace App\Livewire\Hki\Forensic;

use App\Models\HKIAuditLog;
use Livewire\Component;

class Verifier extends Component
{
    public $logId;
    public $status = 'IDLE';
    public $verificationTime;

    public function mount($logId)
    {
        $this->logId = $logId;
    }

    public function verify()
    {
        try {
            $log = HKIAuditLog::with('user')->findOrFail($this->logId);

            $payloadArray = $log->payload;

            if (is_string($payloadArray)) {
                $payloadArray = json_decode($payloadArray, true);
            }

            if (!is_array($payloadArray)) {
                $payloadArray = [];
            }

            ksort($payloadArray);
            $payloadJson = json_encode($payloadArray);

            $timestamp = $log->created_at->format('Y-m-d H:i:s');

            $rawString = $log->previous_hash . $log->user_id . $log->action . $payloadJson . $timestamp;

            $recalculatedHash = hash('sha256', $rawString);

            if ($recalculatedHash !== $log->current_hash) {
                $this->status = 'INVALID_HASH';
                return;
            }

            $publicKey = $log->user->public_key;
            $signature = base64_decode($log->digital_signature);

            $result = openssl_verify(
                $recalculatedHash,
                $signature,
                $publicKey,
                OPENSSL_ALGO_SHA256
            );

            if ($result === 1) {
                $this->status = 'VALID';
            } else {
                $this->status = 'INVALID_SIGNATURE';
            }

        } catch (\Exception $e) {
            $this->status = 'ERROR';
        }

        $this->verificationTime = now();
    }

    public function render()
    {
        return view('livewire.hki.forensic.verifier');
    }
}