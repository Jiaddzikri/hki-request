<?php

namespace App\Request\HKI;

class DecryptPrivateKeyRequest
{
  public ?string $encryptedKey;
  public ?string $pin;
}