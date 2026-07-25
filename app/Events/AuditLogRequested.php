<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuditLogRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $modelClass;
    public $modelId;
    public $action;
    public $payload;
    public $digitalSignature;
    public $userId;

    /**
     * Create a new event instance.
     */
    public function __construct(
        string $modelClass,
        string|int $modelId,
        string $action,
        array $payload = [],
        ?string $digitalSignature = null,
        string|int|null $userId = null
    ) {
        $this->modelClass = $modelClass;
        $this->modelId = $modelId;
        $this->action = $action;
        $this->payload = $payload;
        $this->digitalSignature = $digitalSignature;
        $this->userId = $userId;
    }
}
