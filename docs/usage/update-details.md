# Updating Cart Item Details

You can update the details of an item in the cart, including its name, price, and options, using either `Cart::updateDetails()` or `cart()->updateDetails()` method. This allows you to make specific modifications to the item.

## Method Signature

```php
Cart::updateDetails(mixed $id, array $details);
```

or

```php
cart()->updateDetails(mixed $id, array $details);
```

## Parameters
- `$id` (mixed): The unique identifier of the item you want to update.
- `$details` (array): An associative array containing the details you want to update for the item. This can include name, price, and options.

## Example

Using `Cart::updateDetails()`:

```php
use RealRashid\Cart\Facades\Cart;

// Update the details of an item
Cart::updateDetails($product->id, [
    'name' => 'Updated Product Name',
    'price' => 30.00,
    'options' => ['size' => 'XL', 'color' => 'Red'],
]);
```
Using `cart()->updateDetails()`:

```php
// Update the details of an item
cart()->updateDetails($product->id, [
    'name' => 'Updated Product Name',
    'price' => 30.00,
    'options' => ['size' => 'XL', 'color' => 'Red'],
]);
```

In both examples, we're updating the name, price, and options of the item with the specified ID.

## Details

- The `$id` parameter should be the unique identifier of the item you want to update.
- The `$details` parameter should be an associative array containing the details you want to update for the item.

You can update specific details of an item in the cart using dedicated methods:

- `Cart::updateName($id, $name)`: Update the name of the cart item.
- `Cart::updatePrice($id, $price)`: Update the price of the cart item.
- `Cart::updateOptions($id, array $options)`: Update the options of the cart item.

Alternatively, you can use `Cart::updateDetails($id, $details)` or `cart()->updateDetails($id, $details)` to update multiple details at once.

Remember to replace the sample values in the example with the actual ID and details you want to update.

That's it! You're now equipped to update the details of items in your shopping cart using the Cart package.
