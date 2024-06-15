<?php

namespace RealRashid\Cart\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RealRashid\Cart\Cart
 *
 * @method static mixed add(mixed $id, string $name, int $quantity = 1, float $price, array $options = [], float|null $taxrate = null) Add an item to the cart.
 * @method static Json all() Retrieve all items in the cart as a collection of objects detailed information about each item.
 * @method static void associate($id, $model) Associate an item in the cart with a corresponding model.
 * @method static void clear() Clear the entire cart, removing all items.
 * @method static int count() Return the total number of items in the cart.
 * @method static bool empty() Check if the cart is empty.
 * @method static mixed instance(string|null $instance = null) Get or create an instance of the Cart.
 * @method static mixed get($id) Retrieve the item with the given ID from the cart, returning the item if it exists, or null otherwise.
 * @method static float subtotal() Calculate and return the total subtotal (pre-tax) price for all items in the cart.
 * @method static float tax() Calculate and return the total taxes for all items in the cart.
 * @method static float total() Calculate and return the total price (including taxes) for all items in the cart.
 * @method static void updateQuantity($id, $quantity) Update the quantity of an item in the cart. If the new quantity is less than or equal to 0, the item will be removed from the cart.
 * @method static void updateDetails($id, array $details) Update the details (name, price, options) of an item in the cart.
 * @method static void updateName($id, $name) Update the name of an item in the cart.
 * @method static void updateOptions($id, array $options) Update the options of an item in the cart.
 * @method static void updatePrice($id, $price) Update the price of an item in the cart.
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \RealRashid\Cart\Cart::class;
    }
}
