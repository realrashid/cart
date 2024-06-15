<?php

use App\Models\Product;
use RealRashid\Cart\Facades\Cart;

beforeEach(function () {
    // Clear the cart before each test
    Cart::clear();
    Cart::instance('wishlist')->clear();
    Cart::instance('cart')->clear();
});

it('can add a single item to the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Simulate adding the product to the cart
    Cart::add($product->id, $product->name, 1, $product->price);

    // Assert that the cart contains 1 item
    expect(Cart::count())->toBe(1);

    // Assert that the total price of the items in the cart is $25.00
    expect(Cart::total())->toBe(25.00);
});

it('can add an item with tax to the cart', function () {
    // Set up the configuration for tax
    config(['cart.instances.cart' => [
        'tax_enabled' => true, // Enable tax calculations
        'tax_rate' => 10, // Set a tax rate of 10%
    ],
    ]);

    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Taxable Product',
        'price' => 50.00,
    ]);

    // Simulate adding the taxable product to the cart
    Cart::add($product->id, $product->name, 1, $product->price, []);

    // Assert that the cart contains 1 item
    expect(Cart::count())->toBe(1);

    // Assert that the subtotal is $50.00 (1 item * $50.00 each)
    expect(Cart::subtotal())->toBe(50.00);

    // Assert that the tax amount is $5.00 (10% of $50.00)
    expect(Cart::tax())->toBe(5.00);

    // Assert that the total price is $55.00 (subtotal + tax)
    expect(Cart::total())->toBe(55.00);
});

it('can add an item without tax to the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Non-Taxable Product',
        'price' => 30.00,
    ]);

    // Simulate adding a non-taxable product to the cart
    Cart::add($product->id, $product->name, 1, $product->price, [], 0); // Tax rate set to 0

    // Assert that the cart contains 1 item
    expect(Cart::count())->toBe(1);

    // Assert that the subtotal is $30.00 (1 item * $30.00 each)
    expect(Cart::subtotal())->toBe(30.00);

    // Assert that the tax amount is $0.00 (since tax rate is set to 0)
    expect(Cart::tax())->toBe(0.00);

    // Assert that the total price is $30.00 (subtotal + tax)
    expect(Cart::total())->toBe(30.00);
});

it('throws an exception if tax rate is not provided when tax is enabled', function () {
    // Set up the configuration for tax
    config(['cart.instances.cart' => [
        'tax_enabled' => true, // Enable tax calculations
    ],
    ]);

    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Simulate adding a product without providing a tax rate
    expect(fn () => Cart::add($product->id, $product->name, 1, $product->price))->toThrow(InvalidArgumentException::class);
});

it('can add multiple items to the cart', function () {
    // Create some sample products
    $product1 = Product::factory()->create([
        'name' => 'Product 1',
        'price' => 10.00,
    ]);

    $product2 = Product::factory()->create([
        'name' => 'Product 2',
        'price' => 15.00,
    ]);

    // Simulate adding multiple products to the cart
    Cart::add([
        [
            'id' => $product1->id,
            'name' => $product1->name,
            'quantity' => 2,
            'price' => $product1->price,
            'options' => [
                'size' => 'SM',
                'color' => 'Pink',
            ],
        ],
        [
            'id' => $product2->id,
            'name' => $product2->name,
            'quantity' => 1,
            'price' => $product2->price,
            'options' => [
                'size' => 'M',
                'color' => 'Blue',
            ],
        ],
    ]);

    // Assert that the cart contains 2 items
    expect(Cart::count())->toBe(2);

    // Assert that the total price of the items in the cart is $35.00
    expect(Cart::total())->toBe(35.00);
});

it('throws an exception if quantity is not a positive integer', function () {
    // Test negative quantity
    expect(fn () => Cart::add(1, 'Product A', -0))->toThrow(InvalidArgumentException::class);

    // Test zero quantity
    expect(fn () => Cart::add(1, 'Product A', 0))->toThrow(InvalidArgumentException::class);
});

it('can associate a model with a specific item in the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Add the product to the cart
    Cart::add($product->id, $product->name, 1, $product->price);

    // Get the row ID of the added item
    $rowId = $product->id;

    // Associate the product model with the cart item
    Cart::associate($rowId, $product);

    // Retrieve the cart item and check if the model is associated
    $cartItem = Cart::get($rowId);

    expect($cartItem->getModel())->toBe($product);
});

it('can update the quantity of an item in the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Add the product to the cart
    Cart::add($product->id, $product->name, 1, $product->price);

    // Simulate updating the quantity
    Cart::updateQuantity($product->id, 3);

    // Retrieve the cart item
    $cartItem = Cart::get($product->id);

    // Assert that the quantity is updated to 3
    expect($cartItem->getQuantity())->toBe(3);

    // Assert that the subtotal is $75.00 (3 items * $25.00 each)
    expect(Cart::subtotal())->toBe(75.00);

    // Assert that the total price is $75.00 (including taxes)
    expect(Cart::total())->toBe(75.00);
});

it('can update the name of an item in the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Add the product to the cart
    Cart::add($product->id, $product->name, 1, $product->price);

    // Update the name of the cart item
    Cart::updateName($product->id, 'Updated Product Name');

    // Retrieve the cart item
    $cartItem = Cart::get($product->id);

    // Assert that the name is updated
    expect($cartItem->getName())->toBe('Updated Product Name');
});

it('can update the price of an item in the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Add the product to the cart
    Cart::add($product->id, $product->name, 1, $product->price);

    // Update the price of the cart item
    Cart::updatePrice($product->id, 30.00);

    // Retrieve the cart item
    $cartItem = Cart::get($product->id);

    // Assert that the price is updated
    expect($cartItem->getPrice())->toBe(30.00);
});

it('can update the options of an item in the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Add the product to the cart
    Cart::add($product->id, $product->name, 1, $product->price);

    // Update the options of the cart item
    Cart::updateOptions($product->id, ['size' => 'L', 'color' => 'Blue']);

    // Retrieve the cart item
    $cartItem = Cart::get($product->id);

    // Assert that the options are updated
    expect($cartItem->getOptions())->toBe(['size' => 'L', 'color' => 'Blue']);
});

it('can update the details of an item in the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Add the product to the cart
    Cart::add($product->id, $product->name, 1, $product->price);

    // Update the details of the cart item
    Cart::updateDetails($product->id, [
        'name' => 'Updated Product Name',
        'price' => 30.00,
        'options' => ['size' => 'XL', 'color' => 'Red'],
    ]);

    // Retrieve the cart item
    $cartItem = Cart::get($product->id);

    // Assert that the details are updated
    expect($cartItem->getName())->toBe('Updated Product Name');
    expect($cartItem->getPrice())->toBe(30.00);
    expect($cartItem->getOptions())->toBe(['size' => 'XL', 'color' => 'Red']);
});

it('can remove an item from the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Add the product to the cart
    Cart::add($product->id, $product->name, 1, $product->price);

    // Simulate removing the product from the cart
    Cart::remove($product->id);

    // Assert that the cart is now empty
    expect(Cart::count())->toBe(0);

    // Assert that the total price is $0
    expect(Cart::total())->toBe(0);
});

it('can clear the cart', function () {
    // Create some sample products
    $product1 = Product::factory()->create([
        'name' => 'Product 1',
        'price' => 10.00,
    ]);

    $product2 = Product::factory()->create([
        'name' => 'Product 2',
        'price' => 15.00,
    ]);

    // Add the products to the cart
    Cart::add($product1->id, $product1->name, 2, $product1->price);
    Cart::add($product2->id, $product2->name, 1, $product2->price);

    // Simulate clearing the cart
    Cart::clear();

    // Assert that the cart is now empty
    expect(Cart::count())->toBe(0);

    // Assert that the total price is $0
    expect(Cart::total())->toBe(0);
});

it('can calculate the total taxes for all items in the cart', function () {
    // Create sample products
    $product1 = Product::factory()->create([
        'name' => 'Product 1',
        'price' => 10.00,
    ]);

    $product2 = Product::factory()->create([
        'name' => 'Product 2',
        'price' => 15.00,
    ]);

    // Add the products to the cart with tax rates
    Cart::add($product1->id, $product1->name, 1, $product1->price, [], 10); // 10% tax
    Cart::add($product2->id, $product2->name, 1, $product2->price, [], 8); // 8% tax

    // Calculate the total taxes
    expect(Cart::tax())->toBe(2.20); // Total taxes for both items
});

it('can calculate the total subtotal (pre-tax) price for all items in the cart', function () {
    // Create sample products
    $product1 = Product::factory()->create([
        'name' => 'Product 1',
        'price' => 10.00,
    ]);

    $product2 = Product::factory()->create([
        'name' => 'Product 2',
        'price' => 15.00,
    ]);

    // Add the products to the cart
    Cart::add($product1->id, $product1->name, 1, $product1->price);
    Cart::add($product2->id, $product2->name, 1, $product2->price);

    // Calculate the total subtotal
    expect(Cart::subtotal())->toBe(25.00); // Total pre-tax price for both items
});

it('can calculate the total price (including taxes) for all items in the cart', function () {
    // Create sample products
    $product1 = Product::factory()->create([
        'name' => 'Product 1',
        'price' => 10.00,
    ]);

    $product2 = Product::factory()->create([
        'name' => 'Product 2',
        'price' => 15.00,
    ]);

    // Add the products to the cart with tax rates
    Cart::add($product1->id, $product1->name, 1, $product1->price, [], 10); // 10% tax
    Cart::add($product2->id, $product2->name, 1, $product2->price, [], 8); // 8% tax

    // Calculate the total price
    expect(Cart::total())->toBe(27.20); // Total price including taxes for both items
});

it('can retrieve the total price (including taxes) for all items in the cart with options', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Add the product to the cart with options and tax rate
    Cart::add([
        'id' => $product->id,
        'name' => $product->name,
        'quantity' => 1,
        'price' => $product->price,
        'options' => [
            'size' => 'L',
            'color' => 'Red',
        ],
        'taxrate' => 10,
    ]); // 10% tax

    // Calculate the total price including taxes
    $totalPrice = Cart::total();

    // Assert the total price
    expect($totalPrice)->toBe(27.50);
});

it('can check if an item with a given ID exists in the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Add the product to the cart
    Cart::add($product->id, $product->name, 1, $product->price);

    // Check if the item with ID 1 exists in the cart
    expect(Cart::has($product->id))->toBeTrue();

    // Check if an item with ID 2 exists in the cart (should be false)
    expect(Cart::has(2))->toBeFalse();
});

it('can retrieve all items in the cart', function () {
    // Create sample products
    $product1 = Product::factory()->create([
        'name' => 'Product 1',
        'price' => 10.00,
    ]);

    $product2 = Product::factory()->create([
        'name' => 'Product 2',
        'price' => 15.00,
    ]);

    // Add the products to the cart
    Cart::add($product1->id, $product1->name, 1, $product1->price);
    Cart::add($product2->id, $product2->name, 1, $product2->price);

    // Define the expected result as a JSON-encoded string
    $resultJson = json_encode([
        '1' => [
            'id' => $product1->id,
            'name' => 'Product 1',
            'price' => 10.00,
            'quantity' => 1,
            'options' => [],
            'model' => null,
            'taxrate' => null,
        ],
        '2' => [
            'id' => $product2->id,
            'name' => 'Product 2',
            'price' => 15.00,
            'quantity' => 1,
            'options' => [],
            'model' => null,
            'taxrate' => null,
        ],
    ]);

    // Decode the expected JSON result back to an associative array
    $expectedJson = json_decode($resultJson);

    // Retrieve all items from the cart
    $result = Cart::all();

    // Assert that the result matches the expected JSON structure
    expect($result)->toEqual($expectedJson);
});

it('can retrieve a specific item from the cart', function () {
    // Create a sample product
    $product = Product::factory()->create([
        'name' => 'Sample Product',
        'price' => 25.00,
    ]);

    // Add the product to the cart
    Cart::add($product->id, $product->name, 1, $product->price);

    // Retrieve the cart item
    $cartItem = Cart::get($product->id);

    // Assert that the retrieved item matches the product details
    expect($cartItem->getId())->toBe($product->id);
    expect($cartItem->getName())->toBe($product->name);
    expect($cartItem->getPrice())->toBe($product->price);
    expect($cartItem->getQuantity())->toBe(1);
});

it('can retrieve the total number of unique items in the cart', function () {
    // Create some sample products
    $product1 = Product::factory()->create([
        'name' => 'Product 1',
        'price' => 10.00,
    ]);

    $product2 = Product::factory()->create([
        'name' => 'Product 2',
        'price' => 15.00,
    ]);

    // Add the products to the cart
    Cart::add($product1->id, $product1->name, 2, $product1->price);
    Cart::add($product2->id, $product2->name, 1, $product2->price);

    // Get the total count of unique items in the cart
    $totalCount = Cart::count();

    // Assert that there are 2 unique items in the cart
    expect($totalCount)->toBe(2);
});

it('can add an item to the wishlist instance', function () {
    // Create a sample product for the wishlist
    $product = Product::factory()->create([
        'name' => 'Wishlist Item 1',
        'price' => 10.00,
    ]);

    // Add the product to the wishlist
    Cart::instance('wishlist')->add($product->id, $product->name, 1, $product->price);

    // Assert that the wishlist contains 1 item
    expect(Cart::instance('wishlist')->count())->toBe(1);

    // Assert that the total price of the items in the wishlist is $10.00
    expect(Cart::instance('wishlist')->total())->toBe(10.00);
});

it('can add an item to the cart instance', function () {
    // Create a sample product for the cart
    $product = Product::factory()->create([
        'name' => 'Cart Item 1',
        'price' => 15.00,
    ]);

    // Add the product to the cart
    Cart::instance('cart')->add($product->id, $product->name, 2, $product->price);

    // Assert that the cart contains 1 item
    expect(Cart::instance('cart')->count())->toBe(1);

    // Assert that the total price of the items in the cart is $30.00
    expect(Cart::instance('cart')->total())->toBe(30.00);
});

it('can retrieve all items from the cart instance', function () {
    // Create a sample product for the cart
    $product = Product::factory()->create([
        'name' => 'Cart Item 1',
        'price' => 15.00,
    ]);

    // Add the product to the cart
    Cart::instance('cart')->add($product->id, $product->name, 2, $product->price);

    // Define the expected result as a JSON-encoded string
    $resultJson = json_encode([
        '1' => [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 2,
            'options' => [],
            'model' => null,
            'taxrate' => null,
        ],
    ]);

    // Decode the expected JSON result back to an associative array
    $expectedJson = json_decode($resultJson);

    // Retrieve all items from the cart
    $result = Cart::instance('cart')->all();

    // Assert that the result matches the expected JSON structure
    expect($result)->toEqual($expectedJson);
});

it('can remove an item from the cart instance', function () {
    // Create a sample product for the cart
    $product = Product::factory()->create([
        'name' => 'Cart Item 1',
        'price' => 15.00,
    ]);

    // Add the product to the cart
    Cart::instance('cart')->add($product->id, $product->name, 2, $product->price);

    // Remove the product from the cart
    Cart::instance('cart')->remove($product->id);

    // Assert that the cart is now empty
    expect(Cart::instance('cart')->count())->toBe(0);
});

it('can add another item to the cart', function () {
    // Create a sample product for the cart
    $product = Product::factory()->create([
        'name' => 'Cart Item 2',
        'price' => 20.00,
    ]);

    // Add the product to the cart
    Cart::instance('cart')->add($product->id, $product->name, 3, $product->price);

    // Assert that the cart contains 1 item
    expect(Cart::instance('cart')->count())->toBe(1);

    // Assert that the total price of the items in the cart is $60.00
    expect(Cart::instance('cart')->total())->toBe(60.00);
});

it('creates a cart instance with custom configuration', function () {
    // Define a custom configuration for the 'mustbuy' instance
    config(['cart.instances.mustbuy' => ['tax_rate' => 5]]);

    // Retrieve an instance of the cart with identifier 'mustbuy'
    $mustbuyCart = Cart::instance('mustbuy');

    // Check if the cart instance was created
    expect($mustbuyCart)->toBeInstanceOf(\RealRashid\Cart\Cart::class);

    // Check if the tax rate matches the custom configuration
    expect($mustbuyCart->getTaxRate())->toBe(5);
});

it('defaults to the default configuration if no instance is specified', function () {
    // Define a default configuration with a tax rate of 10
    config(['cart.instances.cart' => ['tax_rate' => 10]]);

    // Create an instance without specifying an instance name
    $defaultCart = Cart::instance();

    // Assert that the instance has the correct tax rate
    expect($defaultCart->getTaxRate())->toBe(10);
});
