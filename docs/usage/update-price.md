# Updating Cart Item Price

You can update the price of an item in the cart using either `Cart::updatePrice()` or `cart()->updatePrice()` method. This can be useful if the price of an item changes or if you want to apply a discount.

## Method Signature

```php
Cart::updatePrice(mixed $id, float $price);
```

or

```php
cart()->updatePrice(mixed $id, float $price);
```

## Parameters
- `$id` (mixed): The unique identifier of the item you want to update.
- `$price` (float): The new price you want to set for the item.

## Example

Using `Cart::updatePrice()`:

```php
use RealRashid\Cart\Facades\Cart;

// Update the price of an item
Cart::updatePrice(3, 30.00);
```
Using `cart()->updatePrice()`:

```php
// Update the price of an item
cart()->updatePrice(3, 30.00);
```

In both examples, we're updating the price of the item with ID `3` to `30.00`.

## Details

- The `$id` parameter should be the unique identifier of the item you want to update.
- The `$price` parameter should be the new price you want to set for the item.

Remember to replace the sample values in the example with the actual ID and price you want to update.

That's it! You're now equipped to update the prices of items in your shopping cart using the Cart package.
