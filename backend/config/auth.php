<?php

return [

    /*a
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'super-admin' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'hospital-admin' => [
            'driver' => 'session',
            'provider' => 'hospitals',
        ],
        'doctor-admin' => [
            'driver' => 'session',
            'provider' => 'doctors',
        ],
        'pharmacy-admin' => [
            'driver' => 'session',
            'provider' => 'pharmacys',
        ],
        'patient' => [
            'driver' => 'session',
            'provider' => 'patients',
        ],
        'ambulance_driver' => [
            'driver' => 'session',
            'provider' => 'ambulance_drivers',
        ],
        'people' => [
            'driver' => 'session',
            'provider' => 'peoples',
        ],
        
        //Api Guards Define
        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],

        'super-admin-api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],

        'hospital-admin-api' => [
            'driver' => 'sanctum',
            'provider' => 'hospitals',
        ],
        'doctor-admin-api' => [
            'driver' => 'sanctum',
            'provider' => 'doctors',
        ],
        'pharmacy-admin-api' => [
            'driver' => 'sanctum',
            'provider' => 'pharmacys',
        ],
        'patient-api' => [
            'driver' => 'sanctum',
            'provider' => 'patients',
        ],
        'ambulance_driver-api' => [
            'driver' => 'sanctum',
            'provider' => 'ambulance_drivers',
        ],
        'people-api' => [
            'driver' => 'sanctum',
            'provider' => 'peoples',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'hospitals' => [
            'driver' => 'eloquent',
            'model' => App\Models\Hospital::class,
        ],

        'doctors' => [
            'driver' => 'eloquent',
            'model' => App\Models\Dcotor::class,
        ],

        'pharmacys' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pharmacy::class,
        ],

        'patients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Patient::class,
        ],
        
        'ambulance_drivers' => [
            'driver' => 'eloquent',
            'model' => App\Models\AmbulanceDriver::class,
        ],

        'peoples' => [
            'driver' => 'eloquent',
            'model' => App\Models\People::class,
        ],
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
