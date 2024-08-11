<?php

namespace RealRashid\Cart\Coupon;

interface Coupon
{
    /**
     * Get the code of the coupon.
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Check if the coupon is valid.
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Get the type of discount ('percentage' or 'fixed_amount').
     *
     * @return string
     */
    public function getDiscountType(): string;

    /**
     * Get the expiry date of the coupon.
     *
     * @return \DateTimeInterface|string
     */
    public function getExpiryDate();

    /**
     * Get the discount amount.
     *
     * @return float
     */
    public function getDiscountAmount(): float;
}
