<?php

return [

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'sms' => [
        'username'  => env('SMS_USERNAME'),
        'password'  => env('SMS_PASSWORD'),
        'sender_id' => env('SMS_SENDER_ID'),
        'msisdn'    => array_filter(array_map('trim', explode(',', env('SMS_MSISDN', '')))),
    ],

    'pagination' => [
        'feedback_pagination' => env('FEEDBACK_PAGINATION', 5),
        'seat_pagination'     => env('SEAT_PAGINATION', 5)
    ],
];