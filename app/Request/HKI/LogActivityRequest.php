<?php

namespace App\Request\HKI;

use App\Models\HKIProposal;
use App\Models\User;
class LogActivityRequest
{
  public User $user;
  public ?string $pin = null;
  public ?HKIProposal $modelType = null;
  public ?string $action = null;
  public ?string $modelId = null;
  public ?array $payload = null;
}