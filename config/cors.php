<?php

return [
    'allowed-origins' => [],

    'allowed-headers' => [
        'X-Requested-With',
        'X-XSRF-TOKEN',
        'Content-Type',
        'Accept',
    ],

    'allowed-methods' => [
        'GET',
    ],

    // These integers are expressed in minutes.
    'throttle' => (object)[
        'rate_limit' => 20,
        'retry_after' => 2,
    ],

    'validation' => [
        'login' => [
            'email' => 'bail|required|email|exists:users|max:255',
            'password' => 'bail|required',
        ],

        'register' => [
            'name' => 'bail|required|max:255',
            'email' => 'bail|required|email|unique:users|max:255',
            'password' => 'bail|required|confirmed',
        ],

        'password-reset' => [],
    ],
];
