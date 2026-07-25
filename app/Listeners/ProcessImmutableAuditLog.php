<?php

namespace App\Listeners;

use App\Events\AuditLogRequested;
use App\Services\HKI\AuditLogService;

class ProcessImmutableAuditLog
{
    /**
     * Handle the event.
     */
    public function handle(AuditLogRequested $event): void
    {
        $isProduction = app()->environment('production');
        $isFeatureEnabled = config('hki.features.immutable_logging');

        // Production Guard: Jika di environment non-production DAN fitur dimatikan, skip logging.
        // Jika di production, selalu log terlepas dari apapun isi .env.
        if (!$isProduction && !$isFeatureEnabled) {
            return; 
        }

        app(AuditLogService::class)->logActivityGlobal([
            'model_type' => $event->modelClass,
            'model_id' => $event->modelId,
            'action' => $event->action,
            'payload' => $event->payload,
            'digital_signature' => $event->digitalSignature,
            'user_id' => $event->userId ?? auth()->id(),
        ]);
    }
}
