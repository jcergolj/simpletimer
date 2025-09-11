<?php

use App\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | which utilizes session storage plus the Eloquent user provider.
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | If you have multiple user tables or models you may configure multiple
    | providers to represent the model / table. These providers may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | window expires and users are asked to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

    /*
    |--------------------------------------------------------------------------
    | Authentication Throttling
    |--------------------------------------------------------------------------
    |
    | These options control rate limiting for authentication endpoints to
    | prevent brute force attacks. The max_attempts setting defines how many
    | attempts are allowed within the decay_minutes window.
    |
    */

    'throttle' => [
        'login' => [
            'max_attempts' => env('LOGIN_MAX_ATTEMPTS', 5),
            'decay_minutes' => env('LOGIN_DECAY_MINUTES', 1),
        ],
        'registration' => [
            'max_attempts' => env('REGISTRATION_MAX_ATTEMPTS', 5),
            'decay_minutes' => env('REGISTRATION_DECAY_MINUTES', 1),
        ],
        'password_reset' => [
            'forgot_max_attempts' => env('PASSWORD_FORGOT_MAX_ATTEMPTS', 3),
            'forgot_decay_minutes' => env('PASSWORD_FORGOT_DECAY_MINUTES', 1),
            'reset_max_attempts' => env('PASSWORD_RESET_MAX_ATTEMPTS', 5),
            'reset_decay_minutes' => env('PASSWORD_RESET_DECAY_MINUTES', 1),
        ],
    ],

];
