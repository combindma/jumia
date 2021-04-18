<?php

return [

    /*
     * The user id, should be an email used in seller center.
     */
    'user_id' => env('JUMIA_USER_ID', ''),

    /*
     * The api url under which data will be sent.
     */
    'api_url' => env('JUMIA_API_URL', 'https://sellercenter-api.jumia.ma'),

    /*
     * The api key used for authentication.
     */
    'api_key' => env('JUMIA_API_KEY', null),

    /*
     * Enable or disable sync with the seller center. Useful for local development.
     */
    'enabled' => env('JUMIA_SYNC_ENABLED', false),

    /*
     * These brands will be deleted from title and description
     */
    'blackList' => [
        'daniel wellington',
        'tissot',
        'guess',
        'swatch',
        'hugo boss',
        'boss',
        'balmain',
        'longines',
        'emporio armani',
        'armani'
    ],

    /*
     * This will be added to xml feed
     */
    'default_weight' => '0.5kg',

    /*
     * This will be added to xml feed
     */
    'default_warranty_duration' => 24,

    /*
     * This will be added to the price of product
     */
    'price_commission' => 15,
];
