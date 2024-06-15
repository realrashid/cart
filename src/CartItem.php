<?php

namespace RealRashid\Cart;

use Exception;
use Illuminate\Database\Eloquent\Model;

class CartItem
{
    /**
     * Unique identifier for the item.
     */
    protected mixed $id;

    /**
     * Name of the item.
     */
    protected string $name;

    /**
     * Price of the item.
     */
    protected float $price;

    /**
     * Quantity of the item.
     */
    protected int $quantity;

    /**
     * Array of additional options for the item.
     */
    protected array $options;

    /**
     * Associated model (optional).
     *
     * @var mixed|null
     */
    protected mixed $model;

    /**
     * Tax rate for the item (optional).
     */
    protected ?float $taxrate;

    /**
     * Constructor to initialize the CartItem instance.
     *
     * @param  mixed  $id Unique identifier for the item.
     * @param  string  $name Name of the item.
     * @param  float  $price Price of the item.
     * @param  int  $quantity Quantity of the item (default is 1).
     * @param  array  $options Array of additional options for the item.
     * @param  mixed  $model Associated model (optional).
     * @param  float  $taxrate Tax rate for the item (optional).
     */
    public function __construct(mixed $id, string $name, float $price, int $quantity = 1, array $options = [], mixed $model = null, float $taxrate = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->options = $options;
        $this->model = $model;
        $this->taxrate = $taxrate;
    }

    /**
     * Get the unique identifier of the item.
     *
     * @return mixed Unique identifier.
     */
    public function getId()
    {
        // Return the unique identifier of the item
        return $this->id;
    }

    /**
     * Get the name of the item.
     *
     * @return string Item name.
     */
    public function getName()
    {
        // Return the name of the item
        return $this->name;
    }

    /**
     * Get the price of the item.
     *
     * @return float Item price.
     */
    public function getPrice()
    {
        // Return the price of the item
        return $this->price;
    }

    /**
     * Get the quantity of the item.
     *
     * @return int Item quantity.
     */
    public function getQuantity()
    {
        // Return the quantity of the item
        return $this->quantity;
    }

    /**
     * Get the additional options for the item.
     *
     * @return array Array of options.
     */
    public function getOptions()
    {
        // Return the options of the item
        return $this->options;
    }

    /**
     * Get the associated model (if any).
     *
     * @return mixed Associated model or null.
     */
    public function getModel()
    {
        // Return the associated model of the item (if any)
        return $this->model;
    }

    /**
     * Get the tax rate for the item (if set).
     *
     * @return mixed Tax rate or null.
     */
    public function getTaxRate()
    {
        // Return the tax rate of the item
        return $this->taxrate;
    }

    /**
     * Set the tax rate for the item.
     *
     * @param  float|null  $taxrate Tax rate for the item (optional).
     */
    public function setTaxRate(float $taxrate = null)
    {
        // Set the tax rate for the item
        $this->taxrate = $taxrate;
    }

    /**
     * Update the name of the item.
     *
     * @param  string  $name The new name for the item.
     */
    public function updateName(string $name): void
    {
        // Set the new name for the item
        $this->name = $name;
    }

    /**
     * Update the price of the item.
     *
     * @param  float  $price The new price for the item.
     */
    public function updatePrice(float $price): void
    {
        // Set the new price for the item
        $this->price = $price;
    }

    /**
     * Update the options of the item.
     *
     * @param  array  $options The new options for the item.
     */
    public function updateOptions(array $options): void
    {
        // Set the new options for the item
        $this->options = $options;
    }

    /**
     * Update the quantity of the item.
     *
     * @param  int  $quantity New quantity value.
     */
    public function updateQuantity($quantity)
    {
        // Set the new quantity value for the item
        $this->quantity = $quantity;
    }

    /**
     * Associate a model with the item.
     *
     * @param  mixed  $model Associated model.
     *
     * @throws Exception If the supplied model class does not exist.
     */
    public function associateModel(Model $model)
    {
        // Check if the associated model is a string and if the class exists
        if (is_string($model) && ! class_exists($model)) {
            // If the class does not exist, throw an exception
            throw new Exception("The supplied model {$model} does not exist.");
        }

        // Set the associated model
        $this->model = $model;
    }

    /**
     * Calculate the subtotal for the item (price * quantity).
     *
     * @return float Subtotal value.
     */
    public function subtotal()
    {
        // Calculate and return the subtotal
        return $this->price * $this->quantity;
    }

    /**
     * Calculate the tax amount for the item (subtotal * tax rate).
     *
     * @return float Tax amount.
     */
    public function tax()
    {
        // Check if a tax rate is set for the item
        if (isset($this->taxrate)) {
            // Calculate tax amount: subtotal * (taxrate / 100)
            return $this->subtotal() * ($this->taxrate / 100);
        }

        // If no tax rate is set, return 0
        return 0;
    }

    /**
     * Calculate the total amount for the item (subtotal + tax).
     *
     * @return float Total amount.
     */
    public function total()
    {
        return $this->subtotal() + $this->tax();
    }
}
