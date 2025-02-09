<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'doku' => [
        'merchant_id' => env('DOKU_MERCHANT_ID'),
        'client_id' => env('DOKU_CLIENT_ID'),
        'api_url' => env('DOKU_API_URL', 'https://sandbox.doku.com'),
        'shared_key' => env('DOKU_SHARED_KEY'),
        'payment' => [
            'payment_due_date' => 60,
            'type' => 'SALE', // Bisa diubah menjadi 'INSTALLMENT' atau 'AUTHORIZE' sesuai kebutuhan
            'payment_method_types' => [
                "VIRTUAL_ACCOUNT_BCA",
                "VIRTUAL_ACCOUNT_BANK_MANDIRI",
                "VIRTUAL_ACCOUNT_BANK_SYARIAH_MANDIRI",
                "VIRTUAL_ACCOUNT_DOKU",
                "VIRTUAL_ACCOUNT_BRI",
                "VIRTUAL_ACCOUNT_BNI",
                "VIRTUAL_ACCOUNT_BANK_PERMATA",
                "VIRTUAL_ACCOUNT_BANK_CIMB",
                "VIRTUAL_ACCOUNT_BANK_DANAMON",
                "ONLINE_TO_OFFLINE_ALFA",
                "CREDIT_CARD",
                "DIRECT_DEBIT_BRI",
                "EMONEY_SHOPEEPAY",
                "EMONEY_OVO",
                "EMONEY_DANA",
                "QRIS",
                "PEER_TO_PEER_AKULAKU",
                "PEER_TO_PEER_KREDIVO",
                "PEER_TO_PEER_INDODANA"
            ],
        ],
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'jokul' => [
        'merchant_id' => env('DOKU_MERCHANT_ID'), // Menggunakan Merchant ID yang sama dengan Doku
        'client_id' => env('DOKU_CLIENT_ID'),     // Menggunakan Client ID dari Doku
        'shared_key' => env('DOKU_SHARED_KEY'),   // Menggunakan Shared Key dari Doku
        'api_url' => env('DOKU_API_URL', 'https://api-sandbox.doku.com'), // Menggunakan API URL Doku
    ],
   'midtrans' => [
        'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
        'client_key' => env('MIDTRANS_CLIENT_KEY'),
        'server_key' => env('MIDTRANS_SERVER_KEY'),
        'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
        'is_sanitized' => true,
        'is_3ds' => true,
        'callback_url' => env('MIDTRANS_CALLBACK_URL'), 
    ],

];
