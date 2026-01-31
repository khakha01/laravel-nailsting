<?php
return [
    'admins' => [
        'prefix' => 'admins',
        'all' => 'admins:all',
        'by_id' => 'admins:id:%s',
    ],

    'permissions' => [
        'prefix' => 'permissions',
        'all' => 'permissions:all',
        'grouped' => 'permissions:grouped',
        'by_id' => 'permissions:id:%s',
    ],

    'booking_dates' => [
        'prefix' => 'booking_dates',
        'open' => 'booking_dates:open',
        'available' => 'booking_dates:available',
        'by_id' => 'booking_dates:id:%s',
    ],

    'booking_time_slots' => [
        'by_booking_date_id' => 'booking_time_slots:booking_date:%s',
    ],

    'categories' => [
        'prefix' => 'categories',
        'all' => 'categories:all',
        'root' => 'categories:root',
        'active' => 'categories:active',
        'with_products' => 'categories:with_products',
        'tree' => 'categories:tree',
        'by_id' => 'categories:id:%s',
        'by_slug' => 'categories:slug:%s',
    ],

    'products' => [
        'prefix' => 'products',
        'all' => 'products:all',
        'active' => 'products:active',
        'by_id' => 'products:id:%s',
        'by_slug' => 'products:slug:%s',
        'by_code' => 'products:code:%s',
        'by_category' => 'products:category:%s',
    ],

    'nail_categories' => [
        'prefix' => 'nail_categories',
        'all' => 'nail_categories:all',
        'root' => 'nail_categories:root',
        'by_id' => 'nail_categories:id:%s',
        'by_slug' => 'nail_categories:slug:%s',
    ],

    'nails' => [
        'prefix' => 'nails',
        'all' => 'nails:all',
        'active' => 'nails:active',
        'by_id' => 'nails:id:%s',
        'by_slug' => 'nails:slug:%s',
    ],

    'banners' => [
        'prefix' => 'banners',
        'all' => 'banners:all',
        'active' => 'banners:active',
        'by_id' => 'banners:id:%s',
    ],
    'bookings' => [
        'prefix' => 'bookings',
        'all' => 'bookings:all',
        'by_id' => 'bookings:id:%s',
    ],
    'nail_bookings' => [
        'prefix' => 'nail_bookings',
        'all' => 'nail_bookings:all',
        'by_id' => 'nail_bookings:id:%s',
    ],
    'post_categories' => [
        'prefix' => 'post_categories',
        'all' => 'post_categories:all',
        'active' => 'post_categories:active',
        'tree' => 'post_categories:tree',
        'by_id' => 'post_categories:id:%s',
        'by_slug' => 'post_categories:slug:%s',
    ],
    'post_tags' => [
        'prefix' => 'post_tags',
        'all' => 'post_tags:all',
        'by_id' => 'post_tags:id:%s',
    ],
    'posts' => [
        'prefix' => 'posts',
        'all' => 'posts:all',
        'published' => 'posts:published',
        'featured' => 'posts:featured',
        'by_id' => 'posts:id:%s',
        'by_slug' => 'posts:slug:%s',
        'by_category' => 'posts:category:%s',
    ],
    'dashboard' => [
        'stats' => 'dashboard:stats',
        'recent' => 'dashboard:recent',
        'status_dist' => 'dashboard:status_distribution',
    ],
];
