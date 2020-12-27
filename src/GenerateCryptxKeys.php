<?php

namespace Blaze\Cryptx;

use Blaze\Cryptx\Cryptx;
use Illuminate\Console\Command;

class GenerateCryptxKeys extends Command
{
    protected $signature = 'cryptx:keys';

    protected $description = 'Generate Private and public key for Cryptx';

    protected $cryptx;

    public function __construct()
    {
        $this->cryptx = new Cryptx();
        parent::__construct();
    }

    public function handle()
    {
        $privateKeyPath = config('cryptx.private_key_path');
        $publicKeyPath = config('cryptx.public_key_path');

        if (file_exists($privateKeyPath)) {
            $this->error("Private key already exists!");
            return false;
        }
        if (file_exists($publicKeyPath)) {
            $this->error("Public key already exists!");
            return false;
        }

        $keyPair = $this->cryptx->generateKeyPair();
        $privateKey = $this->cryptx->extractPrivateKey($keyPair);
        $publicKey = $this->cryptx->extractPublicKey($keyPair);

        file_put_contents($privateKeyPath, $privateKey);
        $this->info("Private key save to $privateKeyPath");

        file_put_contents($publicKeyPath, $publicKey);
        $this->info("Public key save to $publicKeyPath");

        return true;
    }
}
