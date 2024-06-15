# Clearing Cart

In this example, we'll demonstrate how to clear all items from the cart.

## Clear Form

You can use the following form to allow users to clear the entire cart:

```blade
<form action="{{ route('cart.clear') }}" method="post">
    @csrf
    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-1 rounded-full">Clear Cart</button>
</form>
```

## Controller Method

Here's an example of how you can handle cart clearing in your controller:

```php
use RealRashid\Cart\Facades\Cart;

public function clear()
{
    Cart::clear();

    return redirect()->back()->with('success', 'Cart cleared successfully!');
}
```

## Route (web.php)

Don't forget to define the route in your `web.php` file:

```php
use App\Http\Controllers\CartController;

Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
```

In this example, the form allows users to clear all items from the cart. The form is submitted to the `clear` method in your controller, which uses `Cart::clear()` to empty the entire cart. Finally, the user is redirected back to the cart page with a success message.
