<?php

return [
    'allowed-origins' => [],

    'allowed-headers' => [
        'X-Requested-With',
        'X-XSRF-TOKEN',
        'Content-Type',
        'Accept',
    ],

    'throttle' => (object) [
        'rate_limit' => 10,
        'retry_after' => 1, // expressed in minutes
    ],

    'validation' => [
        'login-credentials' => ['email', 'password'],

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
