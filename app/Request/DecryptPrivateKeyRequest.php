<?php

namespace App\Request;

class DecryptPrivateKeyRequest
{
  public ?string $encryptedKey;
  public ?string $pin;
}