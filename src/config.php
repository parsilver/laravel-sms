<?php

return [

    // Support provider..
    // smartcomm, null
    'default' => env('SMS_PROVIDER', null),

    'providers' => [
        'smartcomm' => [
            'username' => env('SMS_SMARTCOMM_USERNAME'),
            'password' => env('SMS_SMARTCOMM_PASSWORD')
        ],

        'null' => []
    ]
];