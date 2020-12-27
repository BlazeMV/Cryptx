<?php

namespace Blaze\Cryptx\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static generateKeyPair()
 * @method static extractPrivateKey($keypair)
 * @method static extractPublicKey($keypair)
 * @method static encrypt(string $payload, bool $encode = true)
 * @method static decrypt(string $payload, bool $encoded = true)
*/

class Cryptx extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cryptx';
    }
}