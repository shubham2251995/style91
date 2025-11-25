<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fraud Detection Rules
    |--------------------------------------------------------------------------
    |
    | Configure which fraud detection rules are enabled and their thresholds
    |
    */

    'enabled' => env('FRAUD_DETECTION_ENABLED', true),

    'rules' => [
        'velocity_check' => true,           // Check for rapid successive orders
        'suspicious_email' => true,         // Check for disposable/suspicious emails
        'multiple_cards' => true,           // Check for multiple payment attempts
        'high_value_first_order' => true,   // Check for unusually high first orders
        'rapid_orders' => true,             // Check for orders placed too quickly after signup
        'mismatched_details' => true,       // Check for mismatched shipping/billing info
    ],

    'thresholds' => [
        'velocity_orders_per_hour' => 3,
        'first_order_max_value' => 500,
        'new_account_minutes' => 10,
        'payment_retry_max' => 3,
    ],

    'risk_levels' => [
        'low' => [
            'min_score' => 0,
            'max_score' => 39,
            'action' => 'approve',
        ],
        'medium' => [
            'min_score' => 40,
            'max_score' => 69,
            'action' => 'review',
        ],
        'high' => [
            'min_score' => 70,
            'max_score' => 100,
            'action' => 'block',
        ],
    ],

    'notifications' => [
        'enabled' => true,
        'channels' => ['database', 'mail'],
        'email' => env('FRAUD_ALERT_EMAIL', 'admin@example.com'),
    ],
];
