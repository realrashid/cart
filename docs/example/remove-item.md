# Removing Item from Cart

In this example, we'll demonstrate how to remove an item from the cart.

## Remove Form

You can use the following form within a loop that iterates over `cart()->all()` to remove each item:

```blade
<form action="{{ route('cart.remove', ['id' => $item->id]) }}" method="post">
    @csrf
    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-1 rounded-full">Remove</button>
</form>
```

## Controller Method

Here's an example of how you can handle the removal in your controller:

```php
use RealRashid\Cart\Facades\Cart;

public function remove($id)
{
    Cart::remove($id);

    return redirect()->back()->with('success', 'Item removed from cart successfully!');
}
```

## Route (web.php)

Don't forget to define the route in your `web.php` file:

```php
use App\Http\Controllers\CartController;

Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
```

In this example, the form allows users to remove an item from the cart. The form is submitted to the `remove` method in your controller, which uses `Cart::remove($id)` to remove the item from the cart. Finally, the user is redirected back to the cart page with a success message.
