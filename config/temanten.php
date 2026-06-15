<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Invitation Expiry
    |--------------------------------------------------------------------------
    | Default number of days before an invitation expires.
    | Set to 0 to disable expiry entirely.
    */
    'invitation_expiry_days' => (int) env('INVITATION_EXPIRY_DAYS', 365),

    /*
    |--------------------------------------------------------------------------
    | Invitation Cache TTL
    |--------------------------------------------------------------------------
    | Default cache TTL in seconds for public invitation pages.
    */
    'invitation_cache_ttl' => (int) env('INVITATION_CACHE_TTL', 3600),

    /*
    |--------------------------------------------------------------------------
    | Signed Image Rate Limit
    |--------------------------------------------------------------------------
    | Dedicated per-minute throttle for signed invitation storage image URLs.
    */
    'signed_image_rate_limit' => (int) env('SIGNED_IMAGE_RATE_LIMIT', 240),

    /*
    |--------------------------------------------------------------------------
    | Public Registration
    |--------------------------------------------------------------------------
    | Client accounts are normally created by order/admin approval flow.
    | Keep public /register disabled unless explicitly needed.
    */
    'public_registration_enabled' => filter_var(env('PUBLIC_REGISTRATION_ENABLED', false), FILTER_VALIDATE_BOOL),

    /*
    |--------------------------------------------------------------------------
    | QRIS Master String
    |--------------------------------------------------------------------------
    | The master QRIS string used to generate dynamic QRIS payments.
    */
    'qris_master_string' => env('QRIS_MASTER_STRING', ''),

    /*
    |--------------------------------------------------------------------------
    | Unsplash API
    |--------------------------------------------------------------------------
    | API key for Unsplash image integration used in demo invitations.
    */
    'unsplash' => [
        'key' => env('UNSPLASH_ACCESS_KEY', ''),
    ],

];