<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

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
    
   'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'model' => env('OPENAI_MODEL', 'gpt-5-mini'),
    ],
      'chunking' => [
        'chunk_size' => env('CHUNK_SIZE', 2000),
        'overlap' => env('CHUNK_OVERLAP', 200),
        'max_chunks' => env('MAX_CHUNKS', 50),
    ],
    
    'analysis' => [
        'max_tokens_per_chunk' => env('MAX_TOKENS_PER_CHUNK', 1500),
        'temperature' => env('ANALYSIS_TEMPERATURE', 0.2),
        'min_confidence' => env('MIN_CONFIDENCE', 60),
    ],
];
