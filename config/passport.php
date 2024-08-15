<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Passport Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration options allows you to customize the behavior of
    | Laravel Passport as needed. You may adjust these settings based
    | on your application's requirements.
    |
    */

    'private_key' => env('PASSPORT_PRIVATE_KEY'),

    'public_key' => env('PASSPORT_PUBLIC_KEY'),

    'client_uuids' => true,

    /*
    |--------------------------------------------------------------------------
    | Personal Access Client Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration option defines the personal access client ID and
    | secret. These are used when generating personal access tokens,
    | which can be used for a variety of authentication scenarios.
    |
    */

    'personal_access_client' => [
        'id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
        'secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Token Expiration Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the expiration time for tokens issued by Passport
    | for your application. You can specify the expiration time for both
    | access tokens and refresh tokens as needed.
    |
    */

    'tokens_expire_in' => 3600,

    'refresh_tokens_expire_in' => 3600,

];