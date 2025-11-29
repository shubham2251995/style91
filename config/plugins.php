<?php

return [
    'squad_mode' => [
        'group' => 'A',
        'name' => 'Squad Mode',
        'description' => 'Enable group buying where friends can pool together to unlock bulk discounts and exclusive deals.',
        'features' => [
            'Create private shopping squads',
            'Share cart links with friends',
            'Unlock tiered discounts based on group size',
            'Real-time squad member tracking'
        ],
        'locations' => [
            'Product pages - "Shop with Squad" button',
            'Cart drawer - Squad invite options',
            'Checkout - Squad discount display'
        ],
        'icon' => '👥'
    ],
    
    'social_unlock' => [
        'group' => 'A',
        'name' => 'Social Unlock',
        'description' => 'Customers can unlock special discounts by sharing products on social media platforms.',
        'features' => [
            'Share-to-unlock discounts',
            'Support for Instagram, Twitter, Facebook',
            'Track social shares and engagement',
            'Customizable discount rewards'
        ],
        'locations' => [
            'Product pages - Social unlock widget',
            'Cart - Social discount banner'
        ],
        'icon' => '🔓'
    ],
    
    'digital_wardrobe' => [
        'group' => 'C',
        'name' => 'Digital Wardrobe',
        'description' => 'Users can save purchased items to their personal digital wardrobe and get AI-powered outfit suggestions.',
        'features' => [
            'Virtual wardrobe management',
            'Outfit combination suggestions',
            'Purchase history visualization',
            'Mix and match recommendations'
        ],
        'locations' => [
            'User profile - Wardrobe tab',
            'Product pages - "Add to Wardrobe" button',
            'Mobile app - Dedicated wardrobe view'
        ],
        'icon' => '👔'
    ],
    
    'fit_check' => [
        'group' => 'C',
        'name' => 'Fit Check',
        'description' => 'Community-driven fit reviews where users upload photos of how items fit and get feedback from the community.',
        'features' => [
            'Upload fit photos',
            'Community ratings and comments',
            'Size recommendation engine',
            'Filter by body type'
        ],
        'locations' => [
            'Product pages - Fit Check gallery',
            'User profile - My Fit Checks',
            'Community feed'
        ],
        'icon' => '📸'
    ],
    
    'tiered_pricing' => [
        'group' => 'N',
        'name' => 'Tiered Pricing',
        'description' => 'Enable volume-based pricing with quantity discounts for bulk orders.',
        'features' => [
            'Flexible pricing tiers',
            'Automatic discount calculation',
            'Visual tier progress indicators',
            'B2B wholesale pricing'
        ],
        'locations' => [
            'Product pages - Pricing tier table',
            'Cart - Tier savings display',
            'Checkout summary'
        ],
        'icon' => '💰'
    ],
    
    'smart_bundling' => [
        'group' => 'E',
        'name' => 'Smart Bundling',
        'description' => 'AI-powered product bundling that suggests complementary items and offers bundle discounts.',
        'features' => [
            'Automatic bundle suggestions',
            'Customizable bundle discounts',
            'Frequently bought together',
            'Complete the look bundles'
        ],
        'locations' => [
            'Product pages - Bundle widget',
            'Cart - Bundle recommendations',
            'Checkout - Last chance bundles'
        ],
        'icon' => '📦'
    ],
    
    'raffles' => [
        'group' => 'B',
        'name' => 'Raffles',
        'description' => 'Create exclusive product raffles where customers enter to win the chance to purchase limited items.',
        'features' => [
            'Raffle entry management',
            'Automated winner selection',
            'Entry limit controls',
            'Winner notification system'
        ],
        'locations' => [
            'Product pages - "Enter Raffle" button',
            'Dedicated raffles page',
            'User dashboard - My entries'
        ],
        'icon' => '🎟️'
    ],
    
    'stock_alert' => [
        'group' => 'B',
        'name' => 'Stock Alerts',
        'description' => 'Low stock warnings and back-in-stock notifications to create urgency and capture demand.',
        'features' => [
            'Real-time stock level display',
            'Back-in-stock email alerts',
            'Customizable threshold warnings',
            'Waiting list management'
        ],
        'locations' => [
            'Product pages - Stock indicator',
            'Out of stock - Alert signup form',
            'Email notifications'
        ],
        'icon' => '⚠️'
    ],
    
    'crowd_drop' => [
        'group' => 'B',
        'name' => 'Crowd-Drop',
        'description' => 'Community-funded product launches where items only go into production if enough interest is shown.',
        'features' => [
            'Funding goal tracking',
            'Backer management',
            'Early bird pricing',
            'Production status updates'
        ],
        'locations' => [
            'Dedicated crowd-drop pages',
            'Home page - Featured drops',
            'User dashboard - Backed projects'
        ],
        'icon' => '🚀'
    ]
];
