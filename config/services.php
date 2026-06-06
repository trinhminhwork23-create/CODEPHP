<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    | This file stores credentials for third-party services used by the app.
    | All sensitive values are read from the .env file via the env() helper
    | so they are never hardcoded and remain safe under config:cache.
    |--------------------------------------------------------------------------
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme'   => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | VNPay Sandbox Configuration
    | Access via: config('services.vnpay.tmn_code'), etc.
    |--------------------------------------------------------------------------
    */
    'vnpay' => [
        'tmn_code'    => env('VNP_TMN_CODE'),
        'hash_secret' => env('VNP_HASH_SECRET'),
        'url'         => env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    ],

];
