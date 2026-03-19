---
name: cart-development
description: Build and manage shopping cart functionality including adding items, calculating totals, and managing multiple cart instances.
---

# Cart Development

## When to use this skill

Use this skill when implementing shopping cart features, e-commerce workflows, or wishlist management in Laravel applications using the `realrashid/cart` package.

## Features

- Publish configuration (`vendor:publish` tag: `cart-config`).
- Manage multiple cart instances (e.g., 'main', 'wishlist').
- Add, update, and remove items with custom options and associated models.
- Automatically calculate subtotals, taxes, and totals based on cart contents.

## Examples

### Adding an item to the cart

```php
use RealRashid\Cart\Facades\Cart;

Cart::add('id_1', 'Product 1', 2, 19.99, ['size' => 'L']);
```

### Updating cart item quantity

```php
Cart::update($rowId, 3); // Update quantity to 3
Cart::update($rowId, ['name' => 'New Product Name']); // Update other details
```

### Associating a cart item with an Eloquent model

```php
Cart::associate($rowId, 'App\Models\Product');
$item = Cart::get($rowId);
echo $item->model->name; // Access associated product model
```

### Showing cart contents and totals

```php
$cartItems = Cart::content();
$total = Cart::total();
$tax = Cart::tax();
```

## Implementation tips for AI agents

- Use `Cart::instance('wishlist')` for multiple cart purposes within the same session.
- Leverage model association to avoid manual database lookups when displaying cart items.
- Suggest `php artisan vendor:publish --tag=cart-config` to customize default tax rates and storage settings.
