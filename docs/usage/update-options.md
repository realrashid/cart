# Updating Cart Item Options

You can update the options of an item in the cart using either `Cart::updateOptions()` or `cart()->updateOptions()` method. This can be useful if you want to modify specific attributes of the item.

## Method Signature

```php
Cart::updateOptions(mixed $id, array $options);
```

or

```php
cart()->updateOptions(mixed $id, array $options);
```

## Parameters
- `$id` (mixed): The unique identifier of the item you want to update.
- `$options` (array): An associative array of the options you want to update for the item.

## Example

Using `Cart::updateOptions()`:

```php
use RealRashid\Cart\Facades\Cart;

// Update the options of an item
Cart::updateOptions(3, ['size' => 'L', 'color' => 'Blue']);
```
Using `cart()->updateOptions()`:

```php
// Update the options of an item
cart()->updateOptions(3, ['size' => 'L', 'color' => 'Blue']);
```

In both examples, we're updating the options of the item with ID `3`.

## Details

- The `$id` parameter should be the unique identifier of the item you want to update.
- The `$options` parameter should be an associative array of the options you want to update for the item.

Remember to replace the sample values in the example with the actual ID and options you want to update.

That's it! You're now equipped to update the options of items in your shopping cart using the Cart package.
