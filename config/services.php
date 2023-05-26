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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' => [
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => '1866112700424077',
        'client_secret' => '7b606b18640402783b7ba2fb6ca9d431',
        'redirect' => 'https://crzglobal.xyz/auth/facebook/callback',
    ],
    'google' => [
        'client_id' => '758391897071-73fov93kt29kaer0j27n973iqrf4nj1l.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://crzglobal.xyz/auth/google/callback',
    ],

];
