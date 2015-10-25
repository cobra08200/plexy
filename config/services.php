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
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'tmdb' => [
      'token'    => env('TMDB_TOKEN'),
    ],

    'spotify' => [
      'id'      => env('SPOTIFY_ID'),
      'secret'  => env('SPOTIFY_SECRET'),
    ],

    'plex' => [
      'username'=> env('PLEX_USERNAME'),
      'password'=> env('PLEX_PASSWORD'),
      'token'=> env('PLEX_TOKEN'),
      'url'=> env('PLEX_SERVER_URL'),
    ],

];
