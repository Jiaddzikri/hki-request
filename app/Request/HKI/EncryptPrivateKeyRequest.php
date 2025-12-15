<?php

namespace App\Request\HKI;

class EncryptPrivateKeyRequest
{
  public ?string $privateKey;
  public ?string $pin;
}