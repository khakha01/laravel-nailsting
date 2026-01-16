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
];
