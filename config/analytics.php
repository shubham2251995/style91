<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Analytics Tracking ID
    |--------------------------------------------------------------------------
    |
    | Your Google Analytics 4 Measurement ID (G-XXXXXXXXXX)
    | or Universal Analytics Tracking ID (UA-XXXXXXXXX-X)
    |
    */
    'tracking_id' => env('GOOGLE_ANALYTICS_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Google Tag Manager ID
    |--------------------------------------------------------------------------
    |
    | Your Google Tag Manager Container ID (GTM-XXXXXXX)
    |
    */
    'gtm_id' => env('GOOGLE_TAG_MANAGER_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Enable Analytics
    |--------------------------------------------------------------------------
    |
    | Enable or disable analytics tracking globally
    |
    */
    'enabled' => env('ANALYTICS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Anonymize IP
    |--------------------------------------------------------------------------
    |
    | Anonymize visitor IP addresses for GDPR compliance
    |
    */
    'anonymize_ip' => true,

    /*
    |--------------------------------------------------------------------------
    | Track Events
    |--------------------------------------------------------------------------
    |
    | Enable automatic event tracking for common e-commerce events
    |
    */
    'track_events' => [
        'page_view' => true,
        'add_to_cart' => true,
        'remove_from_cart' => true,
        'begin_checkout' => true,
        'purchase' => true,
        'view_item' => true,
        'search' => true,
    ],
];
