<?php

namespace App\Services\HKI;


use App\Request\HKI\DecryptPrivateKeyRequest;
use App\Request\HKI\EncryptPrivateKeyRequest;
use App\Response\HKI\DecryptPrivateKeyResponse;
use App\Response\HKI\EncryptPrivateKeyResponse;
use App\Response\HKI\GeneratedKeyPairResponse;
use Exception;

class KeyManagementService 
{
  private const CIPHER_ALGO = 'aes-256-cbc';

  public function generateKeyPair(): GeneratedKeyPairResponse
  {
        $config = [
            "digest_alg" => "sha256",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];

        $res = openssl_pkey_new($config);

        if (!$res) {
            throw new Exception("Gagal generate OpenSSL Key: " . openssl_error_string());
        }

        openssl_pkey_export($res, $privateKey);

        $publicKeyDetails = openssl_pkey_get_details($res);
        $publicKey = $publicKeyDetails["key"];

        $response = new GeneratedKeyPairResponse();
        $response->publicKey = $publicKey;
        $response->privateKey = $privateKey;

        return $response;
  }

  public function encryptPrivateKey(EncryptPrivateKeyRequest $request): EncryptPrivateKeyResponse
  {
    $encryptionKey = hash('sha256', $request->pin, true);
    $ivLen = openssl_cipher_iv_length(self::CIPHER_ALGO);
    $iv = openssl_random_pseudo_bytes($ivLen);

    $encryptedData = openssl_encrypt($request->privateKey, self::CIPHER_ALGO, $encryptionKey, 0, $iv);

    if ($encryptedData === false) {
        throw new Exception("Enkripsi Gagal.");
   }

   $response = new EncryptPrivateKeyResponse();
   $response->base64 = base64_encode($iv . $encryptedData);

    return $response;
  }

  public function decryptPrivateKey(DecryptPrivateKeyRequest $request): DecryptPrivateKeyResponse
    {
        $data = base64_decode($request->encryptedKey);

        $ivLen = openssl_cipher_iv_length(self::CIPHER_ALGO);
        
        $iv = substr($data, 0, $ivLen);
        $ciphertext = substr($data, $ivLen);
        $encryptionKey = hash('sha256', $request->pin, true);

        $decryptedData = openssl_decrypt($ciphertext, self::CIPHER_ALGO, $encryptionKey, 0, $iv);

        if ($decryptedData === false) {
            throw new Exception("PIN Salah atau Kunci Rusak.", 400);
        }
        $decryptedResponse = new DecryptPrivateKeyResponse();
        $decryptedResponse->decrypted = $decryptedData;

        return $decryptedResponse;
    }
}