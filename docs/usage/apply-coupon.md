# Applying a Coupon

Applying a coupon to your cart is a great way to offer discounts and promotions to your customers. With the Cart package, you can easily apply coupons to your cart instance. Follow the instructions below to utilize this feature effectively.

## Method Signature

```php
Cart::applyCoupon(Coupon $coupon);
```

or

```php
cart()->applyCoupon(Coupon $coupon);
```

## Description

- **Parameter**: `Coupon $coupon` - The coupon object to apply.
- **Throws**: `\Exception` - If the coupon is not valid or has expired.
- **Returns**: `$this` - Returns the cart instance to allow method chaining.

## Usage Example

### Creating and Applying a Percentage Coupon

Create a percentage-based coupon and apply it to the cart instance:

```php
use RealRashid\Cart\Facades\Cart;
use App\Coupons\PercentageCoupon;

// Create a percentage-based coupon with code 'PERCENT20', 20% discount, valid until '2024-12-31'.
$percentageCoupon = new PercentageCoupon('PERCENT20', 20, '2024-12-31');

// Apply the percentage coupon to the 'cart' instance of the Cart class.
Cart::instance('cart')->applyCoupon($percentageCoupon);
```

### Creating and Applying a Fixed Amount Coupon

Create a fixed amount coupon and apply it:

```php
use RealRashid\Cart\Facades\Cart;
use App\Coupons\FixedAmountCoupon;

// Create a fixed amount coupon with code 'FIXED10', $10 discount, valid until '2024-12-31'.
$fixedAmountCoupon = new FixedAmountCoupon('FIXED10', 10, '2024-12-31');

// Apply the fixed amount coupon to the 'cart' instance of the Cart class.
Cart::instance('cart')->applyCoupon($fixedAmountCoupon);
```

## Details

When you apply a coupon:

1. **Validation**: The method checks if the coupon is valid and not expired. If the coupon is not valid, an exception is thrown.
2. **Storage**: The applied coupon is stored in the session to ensure that it persists across requests.
3. **Method Chaining**: The method returns the cart instance to allow for method chaining.

## Additional Notes

- Ensure that the coupon class (`PercentageCoupon`, `FixedAmountCoupon`, etc.) is correctly implemented and includes methods to check validity and retrieve discount information.
- To remove an applied coupon, use the `Cart::removeCoupon()` method.
