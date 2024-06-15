# Displaying Cart Items

In this example, we'll show how to display the items in the shopping cart in a Laravel application.

```blade
<div class="w-full md:w-3/4 mx-auto bg-white p-8 shadow-lg rounded-lg mb-6">
    <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>

    <div class="mb-4">
        <p class="text-gray-800 dark:text-gray-200">Number of items in cart: {{ cart()->count() }}</p>
        <p class="text-gray-800 dark:text-gray-200">Tax: ${{ cart()->tax() }}</p>
        <p class="text-gray-800 dark:text-gray-200">Subtotal price of items in cart: ${{ cart()->subtotal() }}</p>
        <p class="text-gray-800 dark:text-gray-200">Total price of items in cart: ${{ cart()->total() }}</p>
    </div>

    @if (cart()->empty())
        <p class="text-gray-800 dark:text-gray-200">Your cart is currently empty.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-100 border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2">#</th>
                        <th class="py-2">Product Name</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">Quantity</th>
                        <th class="py-2">Subtotal</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 1; @endphp
                    @foreach (Cart::all() as $key => $item)
                        <tr>
                            <td class="py-2">{{ $count++ }}</td>
                            <td class="py-2">{{ $item->model->name ?? $item->name }} - ({{ $item->options->color ?? 'N/A' }},{{ $item->options->size ?? 'N/A' }})</td>
                            <td class="py-2">${{ $item->price }}</td>
                            <td class="py-2">
                                <form action="{{ route('cart.update', ['id' => $item->id]) }}" method="post">
                                    @csrf
                                    <input class="w-16 px-2 py-1 border border-gray-300 rounded-full" type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-1 rounded-full">Update</button>
                                </form>
                            </td>
                            <td class="py-2">${{ $item->price * $item->quantity }}</td>
                            <td class="py-2">
                                <form action="{{ route('cart.remove', ['id' => $item->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-1 rounded-full">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="py-2" colspan="4"></td>
                        <td class="py-2 text-gray-800 dark:text-gray-200"><strong>Total:</strong></td>
                        <td class="py-2 text-gray-800 dark:text-gray-200"><strong>${{ cart()->total() }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
```

In this example, we have a view template that displays the shopping cart contents. It shows details like the number of items in the cart, tax, subtotal, and total prices. If the cart is not empty, it lists each item with options to update quantity or remove the item. Finally, it displays the total price of all items in the cart. If the cart is empty, it displays a message indicating so.
