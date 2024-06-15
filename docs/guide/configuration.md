# Configuration Guide 🛠️

Welcome to the configuration guide for the Cart package! In this guide, we'll walk you through the various configuration options available to customize the behavior of Cart in your Laravel application.

## Default Cart Instance 🛒

The default cart instance is the primary cart used for most shopping activities in your application. If a specific instance is not specified, the default instance will be used. You can customize this instance and its configurations in the 'instances' section below.

By default, the 'default' cart instance is set to `'cart'`. You can modify this value by setting the `CART_DEFAULT_INSTANCE` environment variable.

## Cart Instances 🔄

Here, you have the flexibility to define multiple cart instances, each with its own unique configuration settings. This allows you to switch between instances dynamically during runtime, depending on your specific use cases.

### Example Instances:

1. **Default Instance**:
   - Tax Enabled: true
   - Tax Rate: 10% (Represented as `0.10`)

2. **Wishlist Instance**:
   - Tax Enabled: false
   - Tax Rate: 0% (No tax for wishlist)

```php
'instances' => [
    // Default Cart Instance Configuration
    config('cart.default') => [
        'tax_enabled' => env('CART_TAX_ENABLED', true), // Enable tax for this instance
        'tax_rate' => env('CART_DEFAULT_TAXRATE', 0.10), // The default tax rate for this cart instance (0.10 represents 10% tax)
    ],

    // Wishlist Cart Instance Configuration
    'wishlist' => [
        'tax_rate' => 0, // No tax for wishlist
        'tax_enabled' => false, // Disable tax for this instance
    ],
],
```

To customize these configurations, you can modify the `config/cart.php` file in your Laravel application.

That's it! You now have the knowledge to fine-tune the Cart package to suit your specific needs. Happy configuring! 🛠️
