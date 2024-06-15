# Managing Cart Instances

The Cart package allows you to work with multiple instances of the cart. Each instance can have its own unique configurations, making it flexible for various scenarios, such as handling different types of carts or user sessions.

## Setting the Cart Instance

To get or create an instance of the Cart, you can use the `instance` method. This method allows you to specify a custom instance name or retrieve the default instance.

### Method Signature

```php
Cart::instance(string|null $instance = null);
```

or

```php
cart()->instance(string|null $instance = null);
```

## Parameters
- `$instance` (string): The name of the instance.

## Example

Using `Cart::instance()`:

```php
use RealRashid\Cart\Facades\Cart;

// Getting the default cart instance
Cart::instance();

// Getting a specific instance (e.g., 'wishlist')
Cart::instance('wishlist');
```
Using `cart()->instance()`:

```php
cart()->instance(); // Get the default cart instance
cart()->instance('wishlist'); // Get a specific instance (e.g., 'wishlist')
```

## Details

- When called without any arguments, `Cart::instance()` or `cart()->instance()` will return the default cart instance.

- If you pass a custom instance name as an argument (e.g., `'wishlist'`), the method will return that specific instance. If the instance does not exist, it will be created.

- Using named instances can be useful when you need separate carts for different purposes, such as a shopping cart and a wishlist.


Remember to replace `'wishlist'` with your actual instance name if you've defined custom instances in your configuration.

By utilizing multiple instances, you can efficiently manage various types of carts within your application.

That's it! You're now equipped with the knowledge to manage cart instances effectively using the Cart package.
