# Adding Items to the Cart

To add items to the cart, you have two options: using `Cart::add()` or `cart()->add()`. These methods allow you to specify the details of the item you want to add.

## Method Signature

```php
Cart::add(mixed $id, string $name, int $quantity = 1, float $price, array $options = [], float|null $taxrate = null);
```
or

```php
cart()->add(mixed $id, string $name, int $quantity = 1, float $price, array $options = [], float|null $taxrate = null);
```

## Parameters
- `$id` (mixed): The unique identifier of the item.
- `$name` (string): The name of the item.
- `$quantity` (int, optional, default: 1): The quantity of the item.
- `$price` (float): The price of the item.
- `$options` (array, optional): Additional options for the item.
- `$taxrate` (float|null, optional): Tax rate for the item.

## Example

Using `Cart::add()`:

```php
use RealRashid\Cart\Facades\Cart;

// Adding a sample product
Cart::add(1, 'Sample Product', 2, 25.00, ['size' => 'M', 'color' => 'Blue'], 10);
```
Using `cart()->add()`:

```php
cart()->add(1, 'Sample Product', 2, 25.00, ['size' => 'M', 'color' => 'Blue'], 10);
```

In this example, we're adding 2 units of a 'Sample Product' with a price of $25.00 each, specifying options for size and color, and applying a tax rate of 10%.


## Details

- The `$id` parameter should be a unique identifier for the item, allowing you to distinguish it from other items in the cart.
- `$name` is a string that represents the name or description of the item.
- `$quantity` denotes the number of units of the item you want to add. It's optional and defaults to 1.
- `$price` represents the cost of a single unit of the item.
- `$options` is an array that can be used to provide additional information about the item, such as size, color, etc.
- `$taxrate` allows you to specify a tax rate for the item. It's optional.

Remember to replace the sample values in the example with the actual details of the item you want to add.

That's it! You're now ready to start adding items to your shopping cart using the Cart package.
