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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'phone_verify' => [
        'url' => env("PHONE_VERIFY_API_URL", "https://sms.to/v1/verify/number"),
        'key' => env("PHONE_VERIFY_API_KEY"),
    ],
    'booking_engine' => [
        'url' => env("BOOKING_ENGINE_URL", "localhost"),
    ],
    'channex' => [
        'api_base' => env("CHANNEX_API_BASE", "https://staging.channex.io/api/v1"),
        'pci_base'=>env("PCI_BASE", "https://pci.channex.io/api/v1"),
        'api_key' => env("CHANNEX_API_KEY"),
        'pci_master_key'=>env("PCI_MASTER_KEY"),
        'pci_api_key' => env("PCI_API_KEY"),
        'pci_key_id' => env("PCI_KEY_ID"),
        'pci_revision_base'=>env("PCI_REVISION_BASE"),
    ],
    'oxygen' => [
        'api_base' => env("OXYGEN_API_BASE", "https://sandbox-api.oxygen.gr/v1"),
    ]
];
