# Checking if the Cart is Empty

To check if the cart is empty, you can use either `Cart::empty()` or `cart()->empty()`.

## Method Signatures

```php
Cart::empty();
```

or

```php
cart()->empty();
```

## Example

Using `Cart::empty()`:

```php
use RealRashid\Cart\Facades\Cart;

// Check if the cart is empty
Cart::empty();
```
Using `cart()->empty()`:

```php
// Check if the cart is empty
cart()->empty();
```

In both examples, the method will return `true` if the cart is empty, and `false` otherwise.


That's it! You're now equipped to check if the cart is empty using the Cart package.
