# Changelog

All notable changes to `Cart` will be documented in this file.

## v1.1.0 - 2024-08-11

### v1.1.0 - 2024-08-11

#### Added

- **Coupons Feature**: Introduced a powerful new Coupons feature to enhance discount and promotion management.
  
  - **Apply Discounts**: Easily apply both percentage-based and fixed amount coupons to your cart with straightforward method calls.
    
    ```php
    use RealRashid\Cart\Facades\Cart;
    use App\Coupons\PercentageCoupon;
    
    // Create and apply a percentage-based coupon
    $percentageCoupon = new PercentageCoupon('PERCENT20', 20, '2024-12-31');
    Cart::instance('cart')->applyCoupon($percentageCoupon);
    
    ```
  - **Custom Coupons**: Develop custom coupon classes to meet your specific business requirements by implementing the `Coupon` interface. For example, here’s how you can create a fixed amount coupon:
    
    ```php
    <?php
    
    namespace App\Coupons;
    
    use RealRashid\Cart\Coupon\Coupon as CouponContract;
    use App\Models\Coupon as CouponModel;
    
    class FixedAmountCoupon implements CouponContract
    {
        protected $coupon;
    
        public function __construct(CouponModel $coupon)
        {
            $this->coupon = $coupon;
        }
    
        public function getCode(): string
        {
            return $this->coupon->code;
        }
    
        public function isValid(): bool
        {
            return $this->coupon->isValid();
        }
    
        public function getDiscountType(): string
        {
            return 'fixed_amount';
        }
    
        public function getExpiryDate(): string
        {
            return $this->coupon->expiry_date;
        }
    
        public function getDiscountAmount(): float
        {
            return $this->coupon->amount;
        }
    }
    
    ```
  - **Manage Coupons**: New methods to efficiently manage applied coupons.
    
    - **Apply Coupon**: `Cart::applyCoupon($coupon);`
    - **Remove Coupon**: `Cart::removeCoupon();`
    - **Get Coupon Details**: `Cart::getAppliedCouponDetails();`
    
  

#### Updated

- **Documentation**: Updated to include comprehensive instructions on the new Coupons feature, including examples and best practices.

## v1.0.0 - 2024-06-16

### [Initial Release] - 2024-06-16

#### Added

- Core functionality for managing shopping carts within Laravel applications.
- Flexible configuration options to customize cart instances with specific tax rates and other settings.
- Support for managing multiple cart instances, each with its own configurations.
- Intuitive API for seamless integration and interaction with the cart.
- Tax calculation feature, allowing enabling or disabling tax calculations per cart instance.
- Initial set of facade and service provider to integrate Cart into Laravel projects.
- Unit tests and test cases to ensure reliability and functionality.
- Documentation outlining installation, configuration, and usage of the Cart package.
