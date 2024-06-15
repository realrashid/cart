# Updating Cart Item Quantity

In this example, we'll demonstrate how to update the quantity of an item in the cart.

## Update Form

You can use the following form within a loop that iterates over `cart()->all()` to update the quantity of each item:

```blade
<form action="{{ route('cart.update', ['id' => $item->id]) }}" method="post">
    @csrf
    <input class="w-16 px-2 py-1 border border-gray-300 rounded-full" type="number" name="quantity" value="{{ $item->quantity }}" min="1">
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-1 rounded-full">Update</button>
</form>
```

## Controller Method

Here's an example of how you can handle the update in your controller:

```php
use RealRashid\Cart\Facades\Cart;

public function update(Request $request, $id)
{
    $quantity = $request->input('quantity');

    Cart::updateQuantity($id, $quantity);

    return redirect()->back()->with('success', 'Cart updated successfully!');
}
```

## Route (web.php)

Don't forget to define the route in your `web.php` file:

```php
use App\Http\Controllers\CartController;

Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
```

In this example, the form allows users to input a new quantity, which is then sent to the `update` method in your controller. The controller uses `Cart::updateQuantity($id, $quantity)` to update the item's quantity in the cart. Finally, the user is redirected back to the cart page with a success message.
