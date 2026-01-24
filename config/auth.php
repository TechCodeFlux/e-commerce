<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'club' => [
            'driver' => 'session',
            'provider' => 'clubs',
        ],
        'clubmember' => [
            'driver' => 'session',
            'provider' => 'clubmembers', // make sure this matches exactly
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // or Admin model
        ],
        'clubs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Club::class,
        ],
        'clubmembers' => [
            'driver' => 'eloquent',
            'model' => App\Models\ClubMember::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
