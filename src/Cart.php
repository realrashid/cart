<?php

namespace RealRashid\Cart;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;

class Cart
{
    // Holds the items in the cart
    protected $items;

    // Stores instances of the Cart class
    protected static $instances = [];

    // Current instance identifier
    protected $currentInstance;

    // Tax rate for the current cart instance
    protected $taxRate;

    /**
     * Constructor method, called when a Cart object is created.
     * Loads items from session when a new Cart is created.
     */
    public function __construct($instance = null, $config = [])
    {
        $this->currentInstance = $instance ?: config('cart.default', 'cart');

        $this->taxRate = $config['tax_rate'] ?? 0;

        $this->loadFromSession();
    }

    /**
     * Get or create an instance of the Cart.
     *
     * This method allows you to retrieve an existing instance of the Cart class based on the provided
     * identifier, or create a new one if it doesn't exist. If no identifier is provided, it will use
     * the default identifier specified in the configuration file.
     *
     * @param  string|null  $instance The identifier for the cart instance (default is null to use config).
     * @return Cart Returns the Cart object.
     *
     * // Creating a cart instance named 'cart' and adding a product to it
     * Cart::instance('cart')->add([
     *     'id' => 3,
     *     'name' => 'Product 1',
     *     'quantity' => 1,
     *     'price' => 10.00,
     *     'options' => [
     *         'size' => 'XS',
     *         'color' => 'blue'
     *     ]
     * ]);
     *
     * // Creating a different cart instance named 'wishlist' and adding a different product to it
     * Cart::instance('wishlist')->add([
     *     'id' => 2,
     *     'name' => 'Product 2',
     *     'quantity' => 1,
     *     'price' => 10.00,
     *     'options' => [
     *         'size' => 'XS',
     *         'color' => 'pink'
     *     ]
     * ]);
     */
    public function instance($instance = null)
    {
        // If no identifier is provided, use the default from the configuration
        $instance = $instance ?: config('cart.default', 'cart');

        // Retrieve configuration for this instance
        $config = config("cart.instances.$instance", []);

        // If the instance doesn't already exist, create a new one
        if (! isset(static::$instances[$instance])) {
            // Pass the configuration to the constructor
            static::$instances[$instance] = new static($instance, $config);
        }

        // Return the existing or newly created instance
        return static::$instances[$instance] = new static($instance, $config);
    }

    /**
     * Add an item to the cart.
     *
     * Handles both single items and multi-items (items as an array).
     * Multi-item example: add([['id' => 1, 'quantity' => 2], ['id' => 2, 'quantity' => 1]]);
     *
     * @param  mixed  $id      The unique identifier for the item, or an array of items.
     * @param  string|null  $name    The name of the item (optional).
     * @param  int  $quantity The quantity of the item to add (default is 1).
     * @param  float|null  $price   The price of the item (optional).
     * @param  array  $options Additional options for the item (optional).
     * @param  float|null  $taxrate The tax rate for the item (optional).
     * @return Cart Returns the Cart object for method chaining.
     *
     * Usage Example:
     *
     * // Adding a single item without specifying name, price, and taxrate
     * Cart::add(1, null, 2);
     *
     * // Adding a single item with all details
     * Cart::add(2, 'Sample Product', 1, 10.00, ['color' => 'red'], 0.1);
     *
     * // Adding multiple items at once
     * $items = [
     *     ['id' => 3, 'quantity' => 2, 'price' => 15.00, 'options' => ['size' => 'small']],
     *     ['id' => 4, 'quantity' => 1, 'price' => 20.00, 'options' => ['size' => 'large']],
     * ];
     * Cart::add($items);
     */
    public function add($id, string $name = null, int $quantity = 1, float $price = null, array $options = [], float $taxrate = null)
    {
        if (! is_int($quantity) || $quantity <= 0) {
            throw new InvalidArgumentException('Quantity must be a positive integer.');
        }

        // if (! isset($id) || ! isset($name) || ! isset($quantity)) {
        //     throw new InvalidArgumentException('Invalid attributes provided for cart item.');
        // }

        // Check if it's a multi-item addition
        if ($this->isMultiItem($id)) {
            $this->addMultiItem($id);

            return $this; // Return the Cart object for method chaining.
        }

        // Handle both single item addition and array item addition
        if (is_array($id)) {
            $options = Arr::get($id, 'options', []);

            // If the item already exists, update its quantity
            if ($this->has($id['id'])) {
                $this->updateQuantity($id['id'], $this->items->get($id['id'])->getQuantity() + $quantity);

                return $this; // Return the Cart object for method chaining.
            }

            // Create a new CartItem
            $cartItem = $this->createCartItem(
                $id['id'] ?? null,
                $id['name'] ?? null,
                $id['quantity'] ?? 1,
                $id['price'] ?? null,
                $options,
                $id['taxrate'] ?? null
            );
        } else {
            // If the item already exists, update its quantity
            if ($this->has($id)) {
                $this->updateQuantity($id, $this->items->get($id)->getQuantity() + $quantity);

                return $this; // Return the Cart object for method chaining.
            }

            // Create a new CartItem
            $cartItem = $this->createCartItem($id, $name, $quantity, $price, $options, $taxrate);
        }

        // Add the CartItem to the items collection and save to session
        $this->items->put($cartItem->getId(), $cartItem);
        $this->saveToSession();

        return $this; // Return the Cart object for method chaining.
    }

    /**
     * Update the quantity of an item in the cart.
     *
     * If the new quantity is less than or equal to 0, the item will be removed from the cart.
     * Otherwise, the quantity of the item will be updated.
     *
     * @param  mixed  $id The unique identifier of the item.
     * @param  int  $quantity The new quantity for the item.
     *
     * Usage Example:
     *
     * // Updating quantity of an item with ID 1 to 3
     * Cart::updateQuantity(1, 3);
     *
     * // Attempting to update quantity to a value less than or equal to 0 will remove the item
     * Cart::updateQuantity(2, 0); // Item with ID 2 will be removed from the cart
     */
    public function updateQuantity($id, $quantity)
    {
        // Check if the new quantity is a positive integer
        if (! is_int($quantity)) {
            throw new InvalidArgumentException('Quantity must be a positive integer.');
        }

        // Check if the item exists in the cart
        if ($this->has($id)) {
            // Check if the new quantity is less than or equal to 0
            if ($quantity <= 0) {
                // If so, remove the item from the cart
                $this->remove($id);
            } else {
                // Otherwise, update the quantity of the item
                $this->items->get($id)->updateQuantity($quantity);
            }

            // Save the updated cart to the session
            $this->saveToSession();
        }
        // If the item doesn't exist, no action is taken.
    }

    /**
     * Update the details of an item in the cart.
     *
     * @param  mixed  $id The unique identifier of the item.
     * @param  array  $details An array containing the details to update
     *                         (e.g., ['name' => 'New Name', 'price' => 30.00, 'options' => ['size' => 'XL']).
     *
     * Usage Example:
     *
     * // Updating details of an item with ID 1
     * Cart::updateDetails(1, [
     *     'name' => 'New Name',
     *     'price' => 30.00,
     *     'options' => ['size' => 'XL']
     * ]);
     */
    public function updateDetails($id, $details)
    {
        // Check if the item exists in the cart
        if ($this->has($id)) {
            // Retrieve the cart item
            $cartItem = $this->items->get($id);

            // Update the details if provided
            if (isset($details['name'])) {
                $cartItem->updateName($details['name']);
            }

            if (isset($details['price'])) {
                $cartItem->updatePrice($details['price']);
            }

            if (isset($details['options'])) {
                $cartItem->updateOptions($details['options']);
            }

            // Save the updated cart to the session
            $this->saveToSession();
        }
    }

    /**
     * Update the name of the item.
     *
     * @param  mixed  $id The unique identifier of the item.
     * @param  string  $name The new name for the item.
     *
     * Usage Example:
     *
     * // Updating the name of an item with ID 1
     * Cart::updateName(1, 'New Name');
     */
    public function updateName($id, $name)
    {
        // Check if the item exists in the cart
        if ($this->has($id)) {
            // Retrieve the cart item and update its name
            $cartItem = $this->items->get($id);
            $cartItem->updateName($name);

            // Save the updated cart to the session
            $this->saveToSession();
        }
    }

    /**
     * Update the price of the item.
     *
     * @param  mixed  $id The unique identifier of the item.
     * @param  float  $price The new price for the item.
     *
     * Usage Example:
     *
     * // Updating the price of an item with ID 1
     * Cart::updatePrice(1, 30.00);
     */
    public function updatePrice($id, $price)
    {
        // Check if the item exists in the cart
        if ($this->has($id)) {
            // Retrieve the cart item and update its price
            $cartItem = $this->items->get($id);
            $cartItem->updatePrice($price);

            // Save the updated cart to the session
            $this->saveToSession();
        }
    }

    /**
     * Update the options of the item.
     *
     * @param  mixed  $id The unique identifier of the item.
     * @param  array  $options The new options for the item.
     *
     * Usage Example:
     *
     * // Updating the options of an item with ID 1
     * Cart::updateOptions(1, ['size' => 'XL']);
     */
    public function updateOptions($id, $options)
    {
        // Check if the item exists in the cart
        if ($this->has($id)) {
            // Retrieve the cart item and update its options
            $cartItem = $this->items->get($id);
            $cartItem->updateOptions($options);

            // Save the updated cart to the session
            $this->saveToSession();
        }
    }

    /**
     * Remove an item from the cart.
     *
     * @param  mixed  $id The unique identifier of the item to be removed.
     *
     * Usage Example:
     *
     * // Removing an item with ID 1 from the cart
     * Cart::remove(1);
     */
    public function remove($id)
    {
        // Check if the item exists in the cart
        if ($this->has($id)) {
            // Use the 'forget' method to remove the item from the items collection
            $this->items->forget($id);

            // After removing the item, the collection is updated.

            // Save the updated cart to the session
            $this->saveToSession();
        }
        // If the item doesn't exist, no action is taken.
    }

    /**
     * Clear the entire cart, removing all items.
     *
     * Usage Example:
     *
     * // Clearing the entire cart
     * Cart::clear();
     */
    public function clear()
    {
        // Set the items collection to an empty collection, effectively clearing all items.
        $this->items = collect([]);

        // Remove cart data from session
        Session::forget($this->getSessionKey());

        // Save the updated cart to the session
        $this->saveToSession();

        // This ensures that the cleared cart is stored in the session for future use.
    }

    /**
     * Check if an item with a given ID exists in the cart.
     *
     * @param  mixed  $id The unique identifier of the item.
     * @return bool Returns true if the item exists, otherwise false.
     *
     * Usage Example:
     *
     * // Checking if an item with ID 1 exists in the cart
     * $exists = Cart::has(1);
     * if ($exists) {
     *     echo "Item with ID 1 exists in the cart.";
     * } else {
     *     echo "Item with ID 1 does not exist in the cart.";
     * }
     */
    public function has($id)
    {
        // Use the 'has' method of the items collection to check if an item with the given ID exists.
        return $this->items->has($id);
    }

    /**
     * Retrieve the item with a given ID from the cart.
     *
     * @param  mixed  $id The unique identifier of the item.
     * @return mixed|null Returns the item if it exists, otherwise null.
     *
     * Usage Example:
     *
     * // Retrieving an item with ID 1 from the cart
     * $item = Cart::get(1);
     * if ($item) {
     *     echo "Item found!";
     *     // You can now access properties or methods of the retrieved item
     *     $itemName = $item->getName();
     *     $itemPrice = $item->getPrice();
     * } else {
     *     echo "Item with ID 1 not found in the cart.";
     * }
     */
    public function get($id)
    {
        // Use the 'get' method of the items collection to retrieve an item with the given ID.
        return $this->items->get($id);
    }

    /**
     * Retrieve all items in the cart as a collection of objects.
     * This includes various information about each item.
     *
     * @return Json A collection containing information about each item in the cart.
     *
     * Usage Example:
     *
     * // Get all items in the cart as a collection of objects
     * $items = Cart::all();
     * foreach ($items as $item) {
     *     echo "Item ID: " . $item->id . "<br>";
     *     echo "Item Name: " . $item->name . "<br>";
     *     echo "Item Price: " . $item->price . "<br>";
     *     echo "Item Quantity: " . $item->quantity . "<br>";
     *     // Access other properties as needed
     *     if (!is_null($item->model)) {
     *         echo "Associated Model: " . $item->model->name . "<br>";
     *     }
     * }
     */
    public function all()
    {
        // Map through each item in the cart
        return json_decode($this->items->map(function (CartItem $item) {
            // If the item has an associated model, try to associate it with the model.
            if ($item->getModel()) {
                // Associate the item with its corresponding model
                $item->associateModel($item->getModel()::findOrFail($item->getId()));
            }

            // Return an object with detailed information about the item.
            return [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'price' => $item->getPrice(),
                'quantity' => $item->getQuantity(),
                'options' => $item->getOptions(),
                'model' => $item->getModel(),
                'taxrate' => $item->getTaxRate(),
            ];
        })->toJson());
    }

    /**
     * Check if the cart is empty.
     *
     * @return bool True if the cart is empty, otherwise false.
     *
     * This method checks if the cart contains any items.
     *
     * Usage Example:
     *
     * // Check if the cart is empty
     * if (Cart::instance('cart')->empty()) {
     *     echo "The cart is empty.";
     * } else {
     *     echo "The cart is not empty.";
     * }
     */
    public function empty()
    {
        // Use the `isEmpty()` method of the items collection to check if the cart items collection is empty.
        return $this->items->isEmpty();
    }

    /**
     * Get the total number of items in the cart.
     *
     * @return int The total number of items in the cart.
     *
     * Usage Example:
     *
     * // Get the total number of items in the cart
     * $totalItems = Cart::count();
     * echo "Total Items: " . $totalItems;
     */
    public function count()
    {
        // Use the 'count' method of the items collection to get the total number of items.
        return $this->items->count();
    }

    /**
     * Calculate the total taxes for all items in the cart.
     *
     * @return float The total taxes for all items in the cart.
     *
     * Usage Example:
     *
     * // Calculate the total taxes for all items in the cart
     * $totalTaxes = Cart::tax();
     * echo "Total Taxes: " . $totalTaxes;
     */
    public function tax()
    {
        return $this->items->sum(function (CartItem $item) {
            // Calculate taxes for each item and sum them up.
            return $item->tax();
        });
    }

    /**
     * Calculate the total subtotal (pre-tax) price for all items in the cart.
     *
     * @return float The total subtotal price for all items in the cart.
     *
     * Usage Example:
     *
     * // Calculate the total subtotal for all items in the cart
     * $totalSubtotal = Cart::subtotal();
     * echo "Total Subtotal: " . $totalSubtotal;
     */
    public function subtotal()
    {
        return $this->items->sum(function (CartItem $item) {
            // Calculate the subtotal for each item and sum them up.
            return $item->subtotal();
        });
    }

    /**
     * Calculate the total price (including taxes) for all items in the cart.
     *
     * @return float The total price for all items in the cart.
     *
     * Usage Example:
     *
     * // Calculate the total price for all items in the cart
     * $totalPrice = Cart::total();
     * echo "Total Price: " . $totalPrice;
     */
    public function total()
    {
        return $this->items->sum(function (CartItem $item) {
            // Calculate the total price for each item and sum them up.
            return $item->total();
        });
    }

    /**
     * Associate a model with a specific item in the cart.
     *
     * @param  string  $id The unique identifier of the cart item.
     * @param  mixed  $model The associated model to be linked with the item.
     *
     * Usage Example:
     *
     * // $id is the unique identifier of the cart item, and $product is the associated model.
     * Cart::associate($id, $product);
     */
    public function associate($id, $model)
    {
        // Retrieve the cart item with the given row ID
        $cartItem = $this->items->get($id);

        // Associate the provided model with it.
        $cartItem->associateModel($model);

        // Save the updated cart state to the session.
        $this->items->put($id, $cartItem);
        $this->saveToSession();
    }

    /**
     * Get the tax rate for the cart instance.
     *
     * @return float|null The tax rate for the cart instance.
     */
    public function getTaxRate()
    {
        // Return the tax rate of the cart instance
        return $this->taxRate;
    }

    /**
     * Check if the provided item is a multi-item (an array of items).
     *
     * @param  mixed  $item The item to be checked.
     * @return bool True if the item is a multi-item, false otherwise.
     */
    private function isMultiItem($item)
    {
        // Check if the item is an array and if its first element is also an array.
        if (! is_array($item)) {
            return false;
        }

        return is_array(head($item));
    }

    /**
     * Add multiple items to the cart.
     *
     * @param  array  $items An array of items to be added to the cart.
     */
    private function addMultiItem(array $items)
    {
        foreach ($items as $item) {
            // For each item in the provided array, call the 'add' method to add it to the cart.
            $this->add(
                $item['id'],               // Item ID
                $item['name'] ?? null,      // Item name (defaulting to null if not provided)
                $item['quantity'] ?? 1,     // Item quantity (defaulting to 1 if not provided)
                $item['price'] ?? null,      // Item price (defaulting to null if not provided)
                $item['options'] ?? [],     // Item options (defaulting to an empty array if not provided)
                $item['taxrate'] ?? null    // Item tax rate (defaulting to null if not provided)
            );
        }
    }

    /**
     * Create a new CartItem instance.
     *
     * @param  mixed  $id       The unique identifier of the item.
     * @param  string|null  $name     The name of the item (or null if not provided).
     * @param  int  $quantity The quantity of the item.
     * @param  float|null  $price    The price of the item (or null if not provided).
     * @param  array  $options  An array of options for the item.
     * @param  mixed|null  $taxrate  The tax rate for the item (or null if not provided).
     * @return CartItem The created CartItem instance.
     */
    private function createCartItem($id, $name, $quantity, $price, $options, $taxrate)
    {
        // Check if tax is enabled in the configuration
        $taxEnabled = config("cart.instances.$this->currentInstance.tax_enabled");

        // Create a new CartItem instance with the provided attributes
        $cartItem = new CartItem($id, $name, $price, $quantity, $options, null, $taxrate);

        // If tax is enabled and a tax rate is provided, set the tax rate
        if ($taxEnabled && isset($taxrate)) {
            $cartItem->setTaxRate($taxrate);
        }
        // If tax is enabled but tax rate is not provided, use default tax rate or throw an exception
        elseif ($taxEnabled && ! isset($taxrate)) {
            // Retrieve the default tax rate from the configuration (again, for clarity)
            $defaultTaxRate = config("cart.instances.$this->currentInstance.tax_rate");

            // If default tax rate is not provided in the configuration, throw an exception
            if ($defaultTaxRate === null) {
                throw new InvalidArgumentException('Default tax rate is not set in the configuration. Please configure a default tax rate.');
            }

            // Set the default tax rate
            $cartItem->setTaxRate($defaultTaxRate);
        }

        // Return the created CartItem instance
        return $cartItem;
    }

    /**
     * Get the session key for the current cart instance.
     *
     * The session key is used to uniquely identify the cart instance in the session.
     *
     * @return string The session key for the current cart instance.
     */
    protected function getSessionKey()
    {
        return 'cart_'.$this->currentInstance;
    }

    /**
     * Load cart items from the session into the 'items' collection for the current instance.
     *
     * This method retrieves the cart items stored in the session for the current instance and
     * populates the 'items' collection with CartItem objects.
     */
    protected function loadFromSession()
    {
        // Initialize a new collection to store cart items
        $this->items = collect();

        // Get the session key for the current cart instance
        $sessionKey = $this->getSessionKey();

        // Check if the session contains cart items for the current instance
        if (Session::has($sessionKey)) {
            // Retrieve the cart items from the session
            $cartItems = collect(Session::get($sessionKey));

            // Iterate through each cart item and create a CartItem object
            $cartItems->each(function ($item) {
                $cartItem = new CartItem(
                    $item['id'],
                    $item['name'],
                    $item['price'],
                    $item['quantity'],
                    $item['options'],
                    $item['model'],
                    $item['taxrate']
                );

                // Add the CartItem to the 'items' collection with its unique identifier
                $this->items->put($item['id'], $cartItem);
            });
        }
    }

    /**
     * Save cart items from the 'items' collection to the session for the current instance.
     *
     * This method takes the cart items stored in the 'items' collection and prepares them for
     * storage in the session. It filters out any non-CartItem objects, maps the properties of
     * each CartItem, and then stores them in the session using the session key for the current instance.
     */
    protected function saveToSession()
    {
        // Get the session key for the current cart instance
        $sessionKey = $this->getSessionKey();

        // Prepare the cart items for storage in the session
        $cartItems = $this->items
            ->filter(function ($item) {
                return $item instanceof CartItem;
            })
            ->map(function (CartItem $item) {
                return [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'price' => $item->getPrice(),
                    'quantity' => $item->getQuantity(),
                    'options' => $item->getOptions(),
                    'model' => $item->getModel(),
                    'taxrate' => $item->getTaxRate(),
                ];
            })
            ->toArray();

        // Store the prepared cart items in the session
        Session::put($sessionKey, $cartItems);
    }
}
