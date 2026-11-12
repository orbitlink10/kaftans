<?php

return [
    'name' => env('KAFTAN_NAME', 'Kaftan Dress Kenya'),
    'domain' => env('KAFTAN_DOMAIN', 'kaftandresskenya.co.ke'),

    // Canonicals, structured data and sitemap URLs always use the production host,
    // even while reviewing the site on localhost or staging.
    'canonical_base' => rtrim(env('KAFTAN_CANONICAL_BASE', 'https://kaftandresskenya.co.ke'), '/'),

    'tagline' => 'Kaftan dresses in Kenya',
    'description' => 'Shop kaftan dresses for ladies in Kenya. Browse wedding, casual, plus-size, embroidered and beach kaftans with prices in KSh.',

    'preview' => env('KAFTAN_PREVIEW', env('REYANA_PREVIEW', true)),
    'indexable' => env('KAFTAN_INDEXABLE', env('REYANA_INDEXABLE', false)),
    'announcement' => env('KAFTAN_ANNOUNCEMENT', env('REYANA_ANNOUNCEMENT')),

    'contact_email' => env('KAFTAN_CONTACT_EMAIL', env('REYANA_CONTACT_EMAIL')),
    'contact_phone' => env('KAFTAN_CONTACT_PHONE'),
    'whatsapp' => env('KAFTAN_WHATSAPP'),
    'instagram' => env('KAFTAN_INSTAGRAM'),
    'facebook' => env('KAFTAN_FACEBOOK'),
    'tiktok' => env('KAFTAN_TIKTOK'),
    'delivery_note' => env('KAFTAN_DELIVERY_NOTE'),
    'nairobi_delivery_note' => env('KAFTAN_NAIROBI_DELIVERY_NOTE'),
    'pickup_note' => env('KAFTAN_PICKUP_NOTE'),

    // The public storefront only merchandises the kaftan category tree. Existing
    // categories and products stay intact in the dashboard for the owner.
    'storefront_root' => 'kaftan-dresses-for-ladies',

    'checkout_enabled' => false,

    'legacy' => [
        // Deliberately off until the owner confirms whether Reyana is retired and
        // authorises DNS/redirect cutover.
        'redirects_enabled' => env('KAFTAN_REDIRECT_REYANA', false),
        'hosts' => array_values(array_filter(array_map('trim', explode(',', env('KAFTAN_LEGACY_HOSTS', 'reyana.co.ke,www.reyana.co.ke'))))),
        'paths' => [
            '/' => '/',
            '/shop' => '/collections/kaftan-dresses-for-ladies',
            '/collections/new-arrivals' => '/collections/kaftan-dresses-for-ladies',
            '/collections/dresses' => '/collections/kaftan-dresses-for-ladies',
            '/about' => '/about',
            '/contact' => '/contact',
            '/size-guide' => '/size-guide',
            '/delivery-shipping' => '/delivery-shipping',
            '/returns-exchanges' => '/returns-exchanges',
            '/faqs' => '/faqs',
            '/privacy' => '/privacy',
            '/terms' => '/terms',
            '/account' => '/account',
            '/cart' => '/cart',
            '/checkout' => '/checkout',
            '/search' => '/search',
            '/wishlist' => '/wishlist',
            '/blog' => '/blog',
            '/blog/a-wardrobe-that-works-for-you' => '/blog/how-to-choose-a-kaftan-dress-in-kenya',
        ],
        // No genuine kaftan equivalent exists for these old Reyana collections.
        'gone' => [
            '/collections/tops',
            '/collections/bottoms',
            '/collections/matching-sets',
            '/collections/outerwear',
            '/collections/sale',
        ],
        'excluded_prefixes' => ['admin', 'dashboard', 'bookings', 'profile', 'login', 'register', 'forgot-password', 'reset-password', 'new-post', 'pages', 'page', 'storage', 'up'],
    ],
];
