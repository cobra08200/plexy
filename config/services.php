<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain'    => env('MAILGUN_DOMAIN', null),
        'secret'    => env('MAILGUN_SECRET', null),
    ],

    'mandrill' => [
        'secret'    => env('MANDRILL_SECRET', null),
    ],

    'ses' => [
        'key'       => env('SES_KEY', null),
        'secret'    => env('SES_SECRET', null),
        'region'    => 'us-east-1',
    ],

    'stripe' => [
        'model'     => App\User::class,
        'key'       => env('STRIPE_KEY', null),
        'secret'    => env('STRIPE_SECRET', null),
    ],

    'email' => [
        'from'      => env('MAIL_FROM_ADDRESS', null),
    ],

    'tmdb' => [
        'token'     => env('TMDB_TOKEN', null),
    ],

    'spotify' => [
        'id'        => env('SPOTIFY_ID', null),
        'secret'    => env('SPOTIFY_SECRET', null),
    ],

    'pushover' => [
        'token'     => env('PUSHOVER_TOKEN', null),
        'user'      => env('PUSHOVER_USER', null),
    ],

    'plex' => [
        'username'  => env('PLEX_USERNAME', null),
        'password'  => env('PLEX_PASSWORD', null),
        'token'     => env('PLEX_TOKEN', null),
        'url'       => env('PLEX_SERVER_URL', null),
    ],

];
