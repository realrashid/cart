<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cart Instance
    |--------------------------------------------------------------------------
    |
    | This option defines the default cart instance that will be used
    | throughout your application.
    |
    | The 'default' cart instance is used as a fallback when a specific
    | instance is not specified.
    |
    | It serves as the primary cart for most shopping activities in the application.
    |
    | You can customize this instance and its configurations in the 'instances'
    | section below.
    |
    */
    'default' => env('CART_DEFAULT_INSTANCE', 'cart'),

    /*
    |--------------------------------------------------------------------------
    | Cart Instances
    |--------------------------------------------------------------------------
    |
    | Here you can define multiple cart instances, each with its own unique
    | configuration settings.
    |
    | You can then switch between these instances dynamically during runtime.
    |
    | Each instance can have its own tax settings and other configurations.
    |
    */
    'instances' => [

        // Default Cart Instance Configuration
        config('cart.default') => [
            'tax_enabled' => env('CART_TAX_ENABLED', false), // Enable tax for this instance
            'tax_rate' => env('CART_DEFAULT_TAXRATE', 0.10), // The default tax rate for this cart instance (0.10 represents 10% tax)
        ],

        // Wishlist Cart Instance Configuration
        'wishlist' => [
            'tax_rate' => 0, // No tax for wishlist
            'tax_enabled' => false, // Disable tax for this instance
        ],
    ],

];
