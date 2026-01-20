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
    'sms' => [
    'user'        => env('SMS_USER'),
    'key'         => env('SMS_KEY'),
    'sender'      => env('SMS_SENDER'),
    'entity_id'   => env('SMS_ENTITY_ID'),
    'template_id' => env('SMS_TEMPLATE_ID'),
    'country'     => env('SMS_COUNTRY_CODE', '91'),
    'base_url'    => env('SMS_BASE_URL'),
],

	'angel' => [
	    'api_key' => env('ANGEL_API_KEY'),
	    'client_code' => env('ANGEL_CLIENT_CODE'),
	    'password' => env('ANGEL_PASSWORD'),
	    'totp_secret' => env('ANGEL_TOTP_SECRET'),
	    'base_url' => env('ANGEL_BASE_URL'),
	    'market_base_url' => env('ANGEL_MARKET_BASE_URL'),
	    'jwt_ttl_seconds' => env('ANGEL_JWT_TTL_SECONDS', 3300),
	    'default_symbol' => env('ANGEL_DEFAULT_SYMBOL', '99926000'),
	    'scrip_master_url' => env('ANGEL_SCRIP_MASTER_URL', 'https://margincalculator.angelbroking.com/OpenAPI_File/files/OpenAPIScripMaster.json'),
	    'scrip_master_cache_ttl' => env('ANGEL_SCRIP_MASTER_CACHE_TTL', 3600),
	],

	'razorpay' => [
	    'key'    => env('RAZORPAY_KEY'),
	    'secret' => env('RAZORPAY_SECRET'),
	],

];
	
