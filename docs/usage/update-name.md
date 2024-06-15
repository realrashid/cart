# Updating Cart Item Name

You can update the name of an item in the cart using either `Cart::updateName()` or `cart()->updateName()` method. This can be useful if you want to provide a more descriptive or updated name for the item.

## Method Signature

```php
Cart::updateName(mixed $id, string $name);
```

or

```php
cart()->updateName(mixed $id, string $name);
```

## Parameters
- `$id` (mixed): The unique identifier of the item you want to update.
- `$name` (string): The new name you want to set for the item.

## Example

Using `Cart::updateName()`:

```php
use RealRashid\Cart\Facades\Cart;

// Update the name of an item
Cart::updateName(3, 'Updated Product Name');
```
Using `cart()->updateName()`:

```php
// Update the name of an item
cart()->updateName(3, 'Updated Product Name');
```
In both examples, we're updating the name of the item with ID `3` to '`Updated Product Name`'.

## Details

- The `$id` parameter should be the unique identifier of the item you want to update.
- The `$name` parameter should be the new name you want to set for the item.

Remember to replace the sample values in the example with the actual ID and name you want to update.

That's it! You're now equipped to update the names of items in your shopping cart using the Cart package.
