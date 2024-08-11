# Retrieving Coupon Details

To retrieve the details of the currently applied coupon, you can use the method provided by the Cart package. This method will return an object containing information about the coupon, such as the code, type, and discount amount.

## Method Signature

```php
Cart::getAppliedCouponDetails();
```

or

```php
cart()->getAppliedCouponDetails();
```

## Description

- **Returns**: `stdClass|null` - An object containing coupon details (code, type, discountAmount), or `null` if no coupon is applied.

## Usage Example

### Retrieving Applied Coupon Details

To get details about the currently applied coupon:

```php
use RealRashid\Cart\Facades\Cart;

// Retrieve details of the applied coupon from the 'cart' instance of the Cart class.
$couponDetails = Cart::instance('cart')->getAppliedCouponDetails();

// Check if a coupon is applied
if ($couponDetails) {
    echo "Coupon Code: " . $couponDetails->code . "\n";
    echo "Discount Type: " . $couponDetails->type . "\n";
    echo "Discount Amount: " . $couponDetails->discountAmount . "\n";
} else {
    echo "No coupon applied.\n";
}
```

## Details

- **Retrieve Applied Coupon**: The method fetches the applied coupon from the session using `Session::get('appliedCoupon')`.
- **Check Validity**: If no coupon is applied, the method returns `null`.
- **Coupon Details Object**: If a coupon is applied, the method creates a `stdClass` object to store:
  - `code`: The coupon code.
  - `type`: The type of discount (e.g., percentage or fixed amount).
  - `discountAmount`: The calculated discount amount based on the coupon type.
    - **Percentage**: The discount amount is calculated as a percentage of the cart's subtotal.
    - **Fixed Amount**: The discount amount is taken directly from the coupon.

## Additional Notes

- **Discount Calculation**:
  - For percentage-based coupons, the discount is calculated as a percentage of the cart's subtotal and rounded to two decimal places.
  - For fixed-amount coupons, the discount is taken directly from the coupon's specified amount.
- **No Coupon Applied**: If no coupon is applied, the method will return `null`, and you should handle this case accordingly in your application.
