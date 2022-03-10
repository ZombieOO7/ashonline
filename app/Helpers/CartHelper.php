<?php

namespace App\Helpers;

class CartHelper extends BaseHelper
{
    /**
     * -------------------------------------------------------
     * | Get Coupon Discount                                 |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function getCouponDiscount()
    {
        return session()->get('coupon_discount');
    }

    /**
     * -------------------------------------------------------
     * | Get Coupon Code                                     |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function getCouponCode()
    {
        return session()->get('coupon_code');
    }

        /**
     * -------------------------------------------------------
     * | Get Coupon Discount                                 |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function getEmockCouponDiscount()
    {
        return session()->get('emock_coupon_discount');
    }
}
