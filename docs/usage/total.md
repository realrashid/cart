# Getting the Cart Total

To retrieve the total price of all items in the cart (including taxes), you can use either `Cart::total()` or `cart()->total()`.

## Method Signatures

```php
Cart::total();
```

or

```php
cart()->total();
```

## Example

Using `Cart::total()`:

```php
use RealRashid\Cart\Facades\Cart;

// Getting the total
$total = Cart::total();
```
Using `cart()->total()`:

```php
// Getting the total
$total = cart()->total();
```

In both examples, you will receive the total price of all items in the cart, including taxes.


That's it! You're now equipped to get the cart total using the Cart package.
