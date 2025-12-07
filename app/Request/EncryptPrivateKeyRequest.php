<?php

namespace App\Request;

class EncryptPrivateKeyRequest
{
  public ?string $privateKey;
  public ?string $pin;
}