<?php

namespace Blaze\Cryptx;

use Exception;

class Cryptx
{
    protected $privateKey;

    protected $publicKey;

    protected $keyPairOptions = [
        "digest_alg" => "sha256",
        "private_key_bits" => 1024,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    ];

    public function __construct($privateKeyPath = null, $publicKeyPath = null, array $keyPairOptions = [])
    {
        if ($privateKeyPath !== null && !file_exists($privateKeyPath)) {
            throw new Exception("private Key file does not exist at $privateKeyPath");
        }
        if ($publicKeyPath !== null && !file_exists($publicKeyPath)) {
            throw new Exception("Public Key file does not exist at $publicKeyPath");
        }

        $this->privateKey = $privateKeyPath === null ? null : file_get_contents($privateKeyPath);
        $this->publicKey = $publicKeyPath === null ? null : file_get_contents($publicKeyPath);
        $this->keyPairOptions = array_merge($this->keyPairOptions, $keyPairOptions);
    }


    public function generateKeyPair()
    {
        return openssl_pkey_new($this->keyPairOptions);
    }

    public function extractPrivateKey($keypair)
    {
        openssl_pkey_export($keypair, $private);

        return $this->privateKey = $private;
    }

    public function extractPublicKey($keypair)
    {
        return $this->publicKey = openssl_pkey_get_details($keypair)['key'];
    }

    public function encrypt(string $payload, bool $encode = true): string
    {
        if (!$this->privateKey) {
            throw new Exception("Could not encrypt without a private key.");
        }

        openssl_private_encrypt($payload, $encrypted, $this->privateKey);

        return $encode ? base64_encode($encrypted) : $encrypted;
    }

    public function decrypt(string $payload, bool $encoded = true)
    {
        if (!$this->publicKey) {
            throw new Exception("Could not decrypt without a public key.");
        }

        if ($encoded) $payload = base64_decode($payload);

        openssl_public_decrypt($payload, $decrypted, $this->publicKey);

        return $decrypted;
    }
}