# Retrieving All Items in the Cart

To retrieve all items in the cart, you can use the `all()` method. Similar to adding items, you have two options for accessing this method: `Cart::all()` or `cart()->all()`.

## Method Signature

```php
Cart::all();
```
or

```php
cart()->all();
```

## Example

```php
@foreach (Cart::all() as $item)
    // Display item details here
@endforeach
```

```php
@foreach (cart()->all() as $item)
    // Display item details here
@endforeach
```

## Output

When you call `cart()->all()`, it will return a JSON representation of all items in the cart, including detailed information about each item:

```json
{
  "4": {
    "id": 4,
    "name": "Product 4",
    "price": 82.34,
    "quantity": 1,
    "options": {
      "color": "Red",
      "size": "large"
    },
    "model": {
      "id": 4,
      "name": "Product 4",
      "description": "Ab at ipsum est. Voluptatum rerum ut error et pariatur harum. Error illo molestias voluptatum est praesentium dignissimos.",
      "price": "82.34",
      "image": "https://via.placeholder.com/640x480.png/0055ff?text=aut",
      "created_at": "2024-05-17T21:22:16.000000Z",
      "updated_at": "2024-05-17T21:22:16.000000Z"
    },
    "taxrate": null
  },
  "5": {
    "id": 5,
    "name": "Product 5",
    "price": 37.28,
    "quantity": 1,
    "options": {
      "color": "Red",
      "size": "large"
    },
    "model": {
      "id": 5,
      "name": "Product 5",
      "description": "Totam molestiae deserunt quas qui et ut. Vitae beatae ut dolor dolorum. Quod eius ut enim ipsum tempora et eos. Fuga blanditiis odio exercitationem mollitia eum.",
      "price": "37.28",
      "image": "https://via.placeholder.com/640x480.png/002288?text=voluptas",
      "created_at": "2024-05-17T21:22:16.000000Z",
      "updated_at": "2024-05-17T21:22:16.000000Z"
    },
    "taxrate": null
  }
}
```

Each item in the cart is represented by a key-value pair, where the key is the unique identifier of the item, and the value is an object containing details such as `id`, `name`, `price`, `quantity`, `options`, `model`, and `taxrate`.
