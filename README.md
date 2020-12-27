# Cryptx

Simple PHP library for encrypting and decrypting data using private and public pem key files




### Requirements

- PHP 7.2 or higher
- openssl PHP extension


### Installation

`$ composer require blazemv/cryptx`

### Usage

`$ php artisan vendor:publish --provider="Blaze\Cryptx\CryptxServiceProvider"`

`$ php artisan cryptx:keys`

#### Laravel


```php
//anywhere in your app
$encrypted = \Cryptx::encrypt("My Secret String");
$decrypted = \Cryptx::decrypt($encrypted);
```


#### Outside Laravel

```php
<?php

require_once 'vendor/autoload.php';

use Blaze\Cryptx\Cryptx;

// generate keys
$privateKeyPath = 'private.pem';
$publicKeyPath = 'public.pem';

if (!file_exists($publicKeyPath)) {
    $tempCryptx = new Cryptx();
    $keyPair = $tempCryptx->generateKeyPair();
    $privateKey = $tempCryptx->extractPrivateKey($keyPair);
    $publicKey = $tempCryptx->extractPublicKey($keyPair);

    file_put_contents($privateKeyPath, $privateKey);
    file_put_contents($publicKeyPath, $publicKey);
}

// usage
$cryptx = new Cryptx($privateKeyPath, $publicKeyPath);
$cryptx = new Cryptx($privateKeyPath, $publicKeyPath);
$encrypted = $cryptx->encrypt("My Secret String");
$decrypted = $cryptx->decrypt($encrypted);
echo "encrypted => $encrypted\r\n";
echo "decrypted => $decrypted\r\n";
```

### Important
- encrypt method will return a base64 encoded string of encrypted data.
- decrypt method will expect a base64 encoded string of encrypted data.
- You can avoid base64 encoding and decoding by passing false as the second parameter to both methods.
- a Private key is needed to encode data.
- a Public key is needed to decode an encoded data. public key should be derived from the private key that was used during encryption.
- Pass the private and public key path to Cryptx constructor. For laravel, declare these paths in `config/cryptx.php`.
- If you want to only decrypt data, the private key path could be null. Provide the correct public key path.
- decrypt method will return false upon failure. (eg:incorrect public key, invalid encrypted payload, etc...).
- It is highly recommended to use absolute paths as key paths.