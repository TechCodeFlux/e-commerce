<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [

        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins', // ❗ FIXED
        ],
        'club' => [
            'driver' => 'session',
            'provider' => 'clubs',
        ],
        'clubmember' => [
            'driver' => 'session',
            'provider' => 'club_members',
        ],
    ],



    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // or Admin model if you have one
        ],

        'clubs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Club::class,
        ],
        'club_members' => [
            'driver' => 'eloquent',
            'model' => App\Models\ClubMember::class,
        ],
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Password Resets
    
    |--------------------------------------------------------------------------
    */

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
