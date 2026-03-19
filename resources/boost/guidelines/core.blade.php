{{--
  Laravel Boost third-party package AI guideline for realrashid/cart
  Provides concise instructions and examples for AI agents to integrate this package.
--}}

# Cart (realrashid/cart)

Your ultimate solution for seamless shopping cart functionality in Laravel applications. Cart simplifies the complexities of shopping cart operations, from product additions to total calculations.

## Features

- **Multiple Instances**: Support for multiple cart instances (e.g., 'main', 'wishlist').
- **Item Management**: Add, update, remove, and retrieve items with ease.
- **Taxes & Prices**: Automatic calculation of subtotals, taxes, and totals based on configurable rates.
- **Model Association**: Associate cart items with Eloquent models for easy access to product data.
- **Options & Metadata**: Attach custom options (size, color) to each cart item.

## Publishable tags

- `cart-config` — publishes `config/cart.php`

Example: `php artisan vendor:publish --provider="RealRashid\Cart\CartServiceProvider" --tag="cart-config"`

## Typical usage

1. **Add Item to Cart**:
```php
use RealRashid\Cart\Facades\Cart;

Cart::add('id_123', 'Product Name', 1, 9.99, ['size' => 'M']);
```

2. **Retrieve Cart Totals**:
```php
$total = Cart::total();
$subtotal = Cart::subtotal();
$tax = Cart::tax();
```

3. **Associate with Model**:
```php
Cart::associate($rowId, 'App\Models\Product');
$item = Cart::get($rowId);
echo $item->model->name;
```

4. **Multiple Instances**:
```php
Cart::instance('wishlist')->add($id, $name, $qty, $price);
Cart::instance('main')->content();
```

## Configuration hints

- `tax_rate` — default tax percentage.
- `database` — optional configuration for persistent cart storage.

## Notes for Laravel 13

- Fully compatible with Laravel 13 and PHP 8.2+.
- The `Cart` facade provides a clean, fluent interface across all Laravel versions.
