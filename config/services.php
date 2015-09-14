<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

    'mandrill' => [
        'secret' => env('MANDRILL_KEY'),
    ],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],

    'facebook'  => [
        'client_id'     => env('FACEBOOK_CLIENT_ID', ''),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', ''),
        'redirect'      => env('FACEBOOK_CALLBACK_URL', ''),
    ],

    'dropbox'   => [
        'appName'       => env('DROPBOX_APP_NAME', ''),
        'clientId'      => env('DROPBOX_CLIENT_ID', ''),
        'clientSecret'  => env('DROPBOX_CLIENT_SECRET', '')
    ],

    'copy'      => [
        'identifier'    => env('COPY_IDENTIFIER', ''),
        'secret'        => env('COPY_SECRET', ''),
        'baseFolder'    => env('COPY_BASE_FOLDER', '')
    ],

];
