<?php

namespace App\Observers;

use App\Models\UserMasterSecret;
use App\Services\HKI\AuditLogService;

class UserMasterSecretObserver
{
    protected $auditService;

    public function __construct(AuditLogService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * Handle the UserMasterSecret "created" event.
     */
    public function created(UserMasterSecret $userMasterSecret): void
    {
        $this->auditService->logActivityGlobal([
            'model_type' => UserMasterSecret::class,
            'model_id' => $userMasterSecret->id,
            'user_id' => $userMasterSecret->user_id,
            'action' => 'SSS Master Secret Created',
            'payload' => [
                'user_id' => $userMasterSecret->user_id,
            ],
        ]);
    }

    /**
     * Handle the UserMasterSecret "updated" event.
     */
    public function updated(UserMasterSecret $userMasterSecret): void
    {
        $this->auditService->logActivityGlobal([
            'model_type' => UserMasterSecret::class,
            'model_id' => $userMasterSecret->id,
            'user_id' => $userMasterSecret->user_id,
            'action' => 'SSS Master Secret Updated',
            'payload' => [
                'user_id' => $userMasterSecret->user_id,
            ],
        ]);
    }

    /**
     * Handle the UserMasterSecret "deleted" event.
     */
    public function deleted(UserMasterSecret $userMasterSecret): void
    {
        $this->auditService->logActivityGlobal([
            'model_type' => UserMasterSecret::class,
            'model_id' => $userMasterSecret->id,
            'user_id' => $userMasterSecret->user_id,
            'action' => 'SSS Master Secret Deleted (POTENTIAL TAMPERING)',
            'payload' => [
                'user_id' => $userMasterSecret->user_id,
            ],
        ]);
    }

    /**
     * Handle the UserMasterSecret "restored" event.
     */
    public function restored(UserMasterSecret $userMasterSecret): void
    {
        //
    }

    /**
     * Handle the UserMasterSecret "force deleted" event.
     */
    public function forceDeleted(UserMasterSecret $userMasterSecret): void
    {
        $this->auditService->logActivityGlobal([
            'model_type' => UserMasterSecret::class,
            'model_id' => $userMasterSecret->id,
            'user_id' => $userMasterSecret->user_id,
            'action' => 'SSS Master Secret Force Deleted (POTENTIAL TAMPERING)',
            'payload' => [
                'user_id' => $userMasterSecret->user_id,
            ],
        ]);
    }
}
