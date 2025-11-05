<?php

return [

  'defaults' => [
    'guard' => 'web',        // keep default as 'web' (users)
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
    'principal' => [
        'driver' => 'session',
        'provider' => 'principals',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
    'principals' => [
        'driver' => 'eloquent',
        'model' => App\Models\Principal::class,
    ],
],

'passwords' => [
    'users' => [
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
    ],
    'admins' => [
        'provider' => 'admins',
        'table' => 'password_resets_admin',
        'expire' => 60,
        'throttle' => 60,
    ],
    'principals' => [
        'provider' => 'principals',
        'table' => 'password_resets', // can reuse default table
        'expire' => 60,
        'throttle' => 60,
    ],
],


];
