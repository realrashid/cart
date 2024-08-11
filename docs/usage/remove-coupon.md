# Removing a Coupon

If you need to remove a coupon that has been applied to your cart, the Cart package provides a straightforward method to handle this. Removing a coupon will clear it from the session and reset any associated discount.

## Method Signature

```php
Cart::removeCoupon();
```

or

```php
cart()->removeCoupon();
```

## Description

- **Returns**: `$this` - Returns the cart instance to allow method chaining.

## Usage Example

### Removing an Applied Coupon

To remove the currently applied coupon from the cart instance:

```php
use RealRashid\Cart\Facades\Cart;

// Remove the currently applied coupon from the 'cart' instance of the Cart class.
Cart::instance('cart')->removeCoupon();
```

## Details

When you remove a coupon:

1. **Session Update**: The coupon is removed from the session using `Session::forget('appliedCoupon')`. This ensures that the coupon is no longer applied to the cart.
2. **Reset Coupon Property**: The `appliedCoupon` property of the cart instance is set to `null`, clearing any reference to the previously applied coupon.
3. **Method Chaining**: The method returns the cart instance, allowing you to chain additional methods if needed.

## Additional Notes

- Removing a coupon does not affect the cart items or their prices; it simply removes the discount associated with the coupon.
- If you need to apply a different coupon, you can do so after removing the current one.
