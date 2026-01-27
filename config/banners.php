<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Banner Configuration
    |--------------------------------------------------------------------------
    |
    | Configure which banner IDs are used for specific sections of the website.
    | You can change these IDs after creating banners in the admin panel.
    |
    */

    'feedback_banner_id' => env('FEEDBACK_BANNER_ID', 2),
    'home_banner_id' => env('HOME_BANNER_ID', 3),
    // You can add more banner configurations here
    // 'home_slider_banner_id' => env('HOME_SLIDER_BANNER_ID', 2),
    // 'promotion_banner_id' => env('PROMOTION_BANNER_ID', 3),
];
