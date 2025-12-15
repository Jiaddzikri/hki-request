<?php

namespace App\Request;

use App\Models\User;
class LogActivityRequest
{
  public User $user;
  public ?string $pin = null;
  public ?string $modelType = null;
  public ?string $action =null;
  public ?int $modelId = null;
  public ?array $payload = null;




}