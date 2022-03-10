<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Redirect;
use App\Helpers\CartHelper;
use App\Http\Requests\Admin\CouponFormRequest;
use Exception;
use Lang;
class CouponController extends Controller
{
    private $helper;
    public function __construct(CartHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.frontend');
    }

    /**
     * -------------------------------------------------------
     * | Apply/Remove Coupon codes                           |   
     * |                                                     |
     * | @param Request $request                             |
     * | @return Redirect                                    |
     * -------------------------------------------------------
     */
    public function applyCode(CouponFormRequest $request) 
    {
        try{
            /** get code from request */
            $code = $request->code; 
            /** get total from request */
            $total = $request->total; 
            $msgType = 'error';
            /** Check if apply code or remove code */
            if (@$request->type == __('frontend.apply')) { 
                /** Find promo code details using applied coupon */
                $coupon = $this->helper->findByCouponCode($code); 
                /** Get web settings details */
                $webSetting = getWebSettings(); 
                /** Check if coupon is active or not */
                if (@$coupon && @$coupon->status == 1 && @$webSetting->code_status == 1) { 
                    /** Check if total is less then or equal to amount 1 */
                    if ($total <= $coupon->amount_1) { 
                        $msg = __('frontend.min_spend_msg'). config('constant.default_currency_symbol').$coupon->amount_1.'.' ;
                    } else {
                        /** Discount caluclations */
                        $discount = $this->helper->couponCalculation($total,$coupon->discount_2); 
                        /** Check if total is above amount 1 & below amount 2 */
                        if ($total > $coupon->amount_1 && $total < $coupon->amount_2) { 
                            /** Discount caluclations */
                            $discount = $this->helper->couponCalculation($total,$coupon->discount_1); 
                        }
                        /** Store coupon discount into session */
                        session()->put('coupon_discount', $this->helper->numberFormat($discount, 2)); 
                        /** Store coupon code into session */
                        session()->put('coupon_code',$request->code); 
                        /** Set suceess message */
                        $msg = Lang::get('frontend.coupon.coupon_code_applied_success_msg'); 
                        $msgType = 'success'; 
                    }
                } else {
                    /** set error message */
                    $msg = Lang::get('frontend.coupon.code_does_not_exist',['type' => $code]); 
                }
            } else { 
                /** Remove coupon from session */
                $this->helper->flushCouponSessions(); 
                /** set error message */
                $msg = Lang::get('frontend.coupon.coupon_has_been_removed'); 
                $msgType = 'success';
            }
            /** Redirect to cart page */
            return Redirect::route('cart')->with(@$msgType, @$msg); 
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
