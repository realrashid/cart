# Getting the Cart Subtotal (Pre-tax)

To retrieve the subtotal of the cart before tax, you can use either `Cart::subtotal()` or `cart()->subtotal()`.

## Method Signatures

```php
Cart::subtotal();
```

or

```php
cart()->subtotal();
```

## Example

Using `Cart::subtotal()`:

```php
use RealRashid\Cart\Facades\Cart;

// Getting the cart subtotal (pre-tax)
$subtotal = Cart::subtotal();
```
Using `cart()->subtotal()`:

```php
// Getting the cart subtotal (pre-tax)
$subtotal = cart()->subtotal();
```

In both examples, you will receive the subtotal of the items in the cart before any tax calculations.


That's it! You're now equipped to get the cart subtotal (pre-tax) using the Cart package.
