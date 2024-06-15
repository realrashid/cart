# Associating a Model with a Cart Item

To associate a product model with a specific item in the cart, you can use either `Cart::associate()` or `cart()->associate()`.

## Method Signatures

```php
Cart::associate(mixed $id, mixed $model);
```

or

```php
cart()->associate(mixed $id, mixed $model);
```
## Parameters
- `$id` (mixed): The unique identifier of the item you want to associate with the model.
- `$model` (mixed): The model you want to associate with the item.

## Example

Using `Cart::associate()`:

```php
use RealRashid\Cart\Facades\Cart;

// Associate the product model with the cart item
Cart::associate($id, $product);
```
Using `cart()->associate()`:

```php
// Associate the product model with the cart item
cart()->associate($id, $product);
```

You can also achieve this in a single step by using `Cart::add()` or `cart()->add()` with the `associate()` method:

```php
use RealRashid\Cart\Facades\Cart;

// Adding a product and associating it with the model in one step
Cart::add($product->id, $product->name, 1, $product->price)->associate($product->id, $product);
```

or

```php
// Adding a product and associating it with the model in one step
cart()->add($product->id, $product->name, 1, $product->price)->associate($product->id, $product);
```

In both examples, we're associating a product model with a specific item in the cart.

## Output

```json
{
  "2": {
    "id": 2,
    "name": "Product 2",
    "price": 74.61,
    "quantity": 1,
    "model": {
      "id": 2,
      "name": "Product 2",
      "description": "Modi numquam odit dolor cupiditate quae blanditiis delectus odio. Voluptates voluptate earum at unde quidem autem quisquam cum. Consequuntur reprehenderit quod ad et sit tenetur sit. Doloribus voluptate aut enim enim praesentium repudiandae.",
      "price": "74.61",
      "image": "https://via.placeholder.com/640x480.png/00cccc?text=cumque",
      "created_at": "2024-05-17T21:22:16.000000Z",
      "updated_at": "2024-05-17T21:22:16.000000Z"
    },
    "taxrate": null
  }
}
```

## Details

- The `$id` parameter should be the unique identifier of the item you want to update.
- The `$model` parameter should be the model you want to associate with the item.

Remember to replace the sample values in the example with the actual ID and model you want to associate.

That's it! You're now equipped to associate a model with a cart item using the Cart package.
