# Getting the Cart Item Count

To retrieve the total number of items in the cart, you can use either `Cart::count()` or `cart()->count()`.

## Method Signatures

```php
Cart::count();
```

or

```php
cart()->count();
```

## Example

Using `Cart::count()`:

```php
use RealRashid\Cart\Facades\Cart;

// Get the count of items in the cart
Cart::count();
```
Using `cart()->count()`:

```php
// Get the count of items in the cart
cart()->count();
```

In both examples, the method will return the total number of items in the cart.


That's it! You're now equipped to retrieve the count of items in your shopping cart using the Cart package.
