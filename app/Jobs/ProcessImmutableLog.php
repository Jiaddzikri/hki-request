<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\HKIAuditLog;
use App\Models\HkiSystemState;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;


class ProcessImmutableLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $data = $this->data;
            
            // 1. Ekstrak log terakhir untuk entitas spesifik
            $lastLog = HKIAuditLog::where('model_type', $data['model_type'])
                ->where('model_id', $data['model_id'])
                ->latest('id')
                ->first();
                
            $previousHash = $lastLog ? $lastLog->current_hash : str_repeat('0', 64);
            $payload = $data['payload'] ?? [];
            
            // Urutkan payload agar deterministik
            ksort($payload);
            $payloadJson = json_encode($payload);
            $timestamp = now()->format('Y-m-d H:i:s');

            // 2. Kalkulasi SHA-256 Hash Chaining
            $rawString = $previousHash .
                $data['model_type'] .
                $data['model_id'] .
                ($data['user_id'] ?? '') .
                $data['action'] .
                $payloadJson .
                $timestamp;
                
            $currentHash = hash('sha256', $rawString);

            // 3. Simpan Log
            HKIAuditLog::create([
                'user_id' => $data['user_id'] ?? null,
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

            // 4. Update Global State Anchor
            $systemState = HkiSystemState::firstOrCreate(
                ['key' => 'global_audit_state'],
                ['current_global_hash' => str_repeat('0', 64), 'total_logs' => 0]
            );
            
            $newGlobalHash = hash('sha256', $systemState->current_global_hash . $currentHash);
            
            $systemState->update([
                'current_global_hash' => $newGlobalHash,
                'total_logs' => $systemState->total_logs + 1,
            ]);
        });
    }
}

