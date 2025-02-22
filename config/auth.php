<?php

return [


    'defaults' => [
        'guard' => env('AUTH_GUARD', 'school'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'schools'),
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'schools' => [
            'driver' => 'eloquent',
            'model' => App\Models\School::class,
        ],
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 10,
        ],
        'schools' => [
            'provider' => 'schools',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 10,
        ],
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'school' => [
            'driver' => 'session',
            'provider' => 'schools',
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
