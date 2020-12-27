<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Path to Private Key
    |--------------------------------------------------------------------------
    |
    | Specify the path to the private key file.
    | Please use absolute path to avoid errors.
    |
    */
    'private_key_path' => storage_path('private.pem'),

    /*
    |--------------------------------------------------------------------------
    | Path to Public Key
    |--------------------------------------------------------------------------
    |
    | Specify the path to the public key file.
    | Please use absolute path to avoid errors.
    |
    */
    'public_key_path' => storage_path('public.pem'),

    /*
    |--------------------------------------------------------------------------
    | Options for keypair generator
    |--------------------------------------------------------------------------
    |
    | Specify the options to use while generating keypair.
    | Options that will be passed to openssl_pkey_new() method.
    |
    */
    'keypair_options' => [
        'digest_alg' => "sha256",
        'private_key_bits' => 1024,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ]
];