# Removing Items from the Cart

To remove an item from the cart, you can use either `Cart::remove()` or `cart()->remove()`.

## Method Signatures

```php
Cart::remove(mixed $id);

```

or

```php
cart()->remove(mixed $id);
```

## Parameters
- `$id` (mixed): The unique identifier of the item you want to remove from the cart.item.

## Example

Using `Cart::remove()`:

```php
use RealRashid\Cart\Facades\Cart;

// Simulate removing the item from the cart
Cart::remove($id);
```
Using `cart()->remove()`:

```php
// Simulate removing the item from the cart
cart()->remove($id);
```

In both examples, we're removing the item with the with ID `3` from the cart.

## Details

- The `$id` parameter should be the unique identifier of the item you want to remove.


Remember to replace the sample values in the example with the actual ID and options you want to update.

That's it! You're now equipped to remove items from your shopping cart using the Cart package.
