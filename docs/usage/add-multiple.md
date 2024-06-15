# Adding Multiple Items to the Cart

You can add multiple items to the cart in one go using either `Cart::add()` or `cart()->add()`. This is particularly useful when a customer is purchasing more than one type of item.

## Method Signature

```php
Cart::add(array $items);
```

or

```php
cart()->add(array $items);
```

## Parameters
$items (array): An array of items to be added. Each item should be an associative array containing the following keys:
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

// Adding multiple items
Cart::add([
    [
        'id' => 3,
        'name' => 'Product 1',
        'quantity' => 1,
        'price' => 10.00,
        'options' => [
            'size' => 'XS',
            'color' => 'blue'
        ]
    ],
    [
        'id' => 4,
        'name' => 'Product 2',
        'quantity' => 1,
        'price' => 10.00,
        'options' => [
            'size' => 'large',
            'color' => 'red'
        ]
    ]
]);
```
Using `cart()->add()`:

```php
// Adding multiple items
cart()->add([
    [
        'id' => 3,
        'name' => 'Product 1',
        'quantity' => 1,
        'price' => 10.00,
        'options' => [
            'size' => 'XS',
            'color' => 'blue'
        ]
    ],
    [
        'id' => 4,
        'name' => 'Product 2',
        'quantity' => 1,
        'price' => 10.00,
        'options' => [
            'size' => 'large',
            'color' => 'red'
        ]
    ]
]);
```
In both examples, we're adding multiple items to the cart. Each item is represented as an associative array containing the item's details.

## Details

- The `$items` parameter should be an array of items, where each item is an associative array with the required keys (`id`, `name`, `quantity`, `price`) and optional keys (`options`, `taxrate`). 

Remember to replace the sample values in the example with the actual details of the items you want to add.

That's it! You're now equipped to add multiple items to your shopping cart using the Cart package.
