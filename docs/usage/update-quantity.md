# Updating Cart Item Quantity

You can easily update the quantity of an item in the cart using either `Cart::updateQuantity()` or `cart()->updateQuantity()` method. This is useful when a customer wants to change the quantity of an item before checkout.

## Method Signature

```php
Cart::updateQuantity(mixed $id, int $quantity);
```

or

```php
cart()->updateQuantity(mixed $id, int $quantity);
```

## Parameters
- `$id` (mixed): The unique identifier of the item you want to update.
- `$quantity` (int): The new quantity you want to set for the item.

## Example

Using `Cart::updateQuantity()`:

```php
use RealRashid\Cart\Facades\Cart;

// Update the quantity of an item
Cart::updateQuantity(3, 5);
```
Using `cart()->updateQuantity()`:

```php
// Update the quantity of an item
cart()->updateQuantity(3, 5);
```
In both examples, we're updating the quantity of the item with ID `3` to `5`.

## Details

- The `$id` parameter should be the unique identifier of the item you want to update.
- The `$quantity` parameter should be the new quantity you want to set for the item.

Remember to replace the sample values in the example with the actual ID and quantity you want to update.

That's it! You're now equipped to update the quantity of items in your shopping cart using the Cart package.
