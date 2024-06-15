# Usage

After successfully installing the Cart package, you can start managing your shopping cart using the following methods:


```php
Cart::add(mixed $id, string $name, int $quantity = 1, float $price, array $options = [], float|null $taxrate = null);
```

Adds an item to the cart.


```php
Cart::all();
```

Retrieves all items in the cart as a collection of objects with detailed information about each item.

```php
Cart::associate($id, $model);
```

Associates an item in the cart with a corresponding model.

```php
Cart::clear();
```

Clears the entire cart, removing all items.

```php
Cart::count();
```

Returns the total number of items in the cart.

```php
Cart::empty();
```

Checks if the cart is empty.

```php
Cart::get($id);
```

Retrieves the item with the given ID from the cart, returning the item if it exists, or null otherwise.


```php
Cart::subtotal();
```

Calculates and returns the subtotal (pre-tax) price for all items in the cart.

```php
Cart::tax();
```

Calculates and returns the total taxes for all items in the cart.

```php
Cart::total();
```

Calculates and returns the total price (including taxes) for all items in the cart.

```php
Cart::updateQuantity($id, $quantity);
```

Updates the quantity of an item in the cart. If the new quantity is less than or equal to 0, the item will be removed from the cart.

```php
Cart::updateDetails($id, array $details);
```

Updates the details (name, price, options) of an item in the cart.

```php
Cart::updateName($id, $name);
```

Updates the name of an item in the cart.

```php
Cart::updateOptions($id, array $options);
```

Updates the options of an item in the cart.

```php
Cart::updatePrice($id, $price);
```

Updates the price of an item in the cart.
