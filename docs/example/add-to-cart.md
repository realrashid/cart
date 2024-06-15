# Adding Items to the Cart

In this example, we'll demonstrate how to allow users to add items to their shopping cart in a Laravel application.

## Step 1: View

```blade
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach ($products as $product)
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ $product->name }}</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $product->description }}</p>
            <p class="text-green-600 dark:text-green-400 text-lg font-semibold mb-4">${{ $product->price }}</p>
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <x-text-input type="number" name="quantity" value="1" class="w-16 py-2 px-4 border border-gray-300 rounded-full mb-2" />
                <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white px-4 py-2 rounded-full">Add to Cart</button>
            </form>
        </div>
    @endforeach
</div>
```

## Step 2: Controller Method

```php
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\Cart\Facades\Cart;

public function addToCart(Request $request, Product $product)
{
    $id = $product->id;
    $name = $product->name;
    $price = $product->price;
    $quantity = $request->input('quantity');

    Cart::add([
        'id' => $id,
        'name' => $name,
        'quantity' => $quantity,
        'price' => $price,
        'options' => [
            'color' => 'Red',
            'size' => 'large'
        ],
        "taxrate" => 10
    ])->associate($id, $product);

    return redirect()->back()->with('success', 'Item added to cart successfully!');
}
```

## Step 3: Route (web.php)

```php
use App\Http\Controllers\CartController;

Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
```

In this example, we've provided a sample view with products and a form to add them to the cart. The controller method `addToCart` is responsible for processing the request, extracting necessary information, and adding the item to the cart using the Cart package. Finally, we've set up a route to handle the form submission.
