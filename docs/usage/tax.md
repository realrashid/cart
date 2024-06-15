# Getting the Cart Tax

To retrieve the total taxes applied to the cart, you can use either `Cart::tax()` or `cart()->tax()`.

> **Note:** Before using this method, ensure that tax calculations are enabled. Refer to the [configuration](/guide/configuration.md) for more information.

## Method Signatures

```php
Cart::tax();
```

or

```php
cart()->tax();
```

## Example

Using `Cart::tax()`:

```php
use RealRashid\Cart\Facades\Cart;

// Getting the total taxes
$taxes = Cart::tax();
```
Using `cart()->tax()`:

```php
// Getting the total taxes
$taxes = cart()->tax();
```

In both examples, you will receive the total taxes applied to the items in the cart.


That's it! You're now equipped to get the cart tax using the Cart package.
