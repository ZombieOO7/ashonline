<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Helpers\OrderHelper;
use App\Helpers\PaperHelper;
use App\Helpers\CartHelper;
use App\Helpers\MockTestHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponFormRequest;
use App\Http\Requests\Admin\PaymentFormRequest;
use App\Models\Cart;
use App\Models\MockTest;
use App\Models\Order;
use App\Models\OrderItem;
use Redirect;
use Illuminate\Support\Facades\Lang;
use App\Models\Paper;
use App\Models\PromoCode;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $helper,$paperHelper,$cartHelper;
    public function __construct(OrderHelper $helper,PaperHelper $paperHelper,CartHelper $cartHelper,MockTestHelper $mockTestHelper)
    {
        $this->helper = $helper;
        $this->paperHelper = $paperHelper;
        $this->mockTestHelper = $mockTestHelper;
        $this->cartHelper = $cartHelper;
        $this->helper->mode = config('constant.frontend');
    }

    /**
     * -------------------------------------------------------
     * | Get cart details                                    |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function cart()
    {
        try{
            /** Get all cart papers */
            $cartProducts = $this->helper->getCartAllProducts();
            /** Get checkout papers */
            $checkoutProducts = $this->paperHelper->getCheckoutProducts($cartProducts);
            /** Get related papers */
            $relatedProducts = $this->paperHelper->getCartRelatedProducts($cartProducts);
            /** Get cart sub total */
            $cartSubTotal = $this->helper->cartSubTotal($cartProducts);
            /** Get total coupon discount */
            $couponTotalDiscount = $this->cartHelper->getCouponDiscount();
            $total = $cartSubTotal;
            /** Check if applied for discount */
            if($couponTotalDiscount) {
                /** Substract discount from cart subtotal */
                $amt = $cartSubTotal - $couponTotalDiscount;
                /** Format the final total */
                $total = $this->helper->numberFormat($amt,2);
                /** Check if coupon applied changed or not */
                $sessionCode = session()->get('coupon_code');
                /** Find promo code details using applied coupon */
                $coupon = $this->helper->findByCouponCode($sessionCode);
                /** Get web settings details */
                $webSetting = getWebSettings();
                /** Remove coupon from session */
                if($coupon == null || @$webSetting->code_status == 0) {
                    $this->helper->flushCouponSessions();
                    $couponTotalDiscount = "";
                }
            }
            return view('frontend.orders.cart',['products' => @$cartProducts,'checkoutProducts' => @$checkoutProducts,'relatedProducts' => @$relatedProducts,'cartSubTotal' => @$cartSubTotal,'couponDiscount' => @$couponTotalDiscount,'total' => @$total]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    /**
     * -------------------------------------------------------
     * | Add To Cart                                         |
     * |                                                     |
     * | @param Request $request                             |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function addToCart(Request $request)
    {
        try{
            $cartProducts = [];
            /** Get card papers from session */
            $cartProducts = session()->get('cartProducts');
            $mockProducts = session()->get('mockCartProducts');
            $paper = Paper::whereId($request->paper_id)->first();
            /** Check if paper is already added into cart or not */
            if ($cartProducts && in_array($request->paper_id,$cartProducts)) {
                return response()->json(['error' => Lang::get('frontend.cart.this_paper_is_already_added_to_cart')]);
            } else if(@$paper && $paper->status == 0 || $paper->deleted_at != null || $paper->category->status == 0 ) {
                return response()->json(['error' => __('frontend.paper_no_longer_available_msg')]);
            } else {
                $cartProducts[] = $request->paper_id;
                /** Put papers ids into session */
                session()->put('cartProducts', $cartProducts);
                /** Update the coupon calculations */
                $this->updateCouponCalculations($cartProducts,$mockProducts);
                /** Return json response */
                return response()->json(['total' => count($cartProducts)]);
            }
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------------
     * | Remove papers from cart                             |
     * |                                                     |
     * | @param Request $request                             |
     * | @return Redirect                                    |
     * -------------------------------------------------------
     */
    public function removePaperFromCart(Request $request)
    {
        try{
            /** Pull all cart papers from session */
            $cartProducts = session()->pull('cartProducts', []);
            $mockProducts = session()->get('mockCartProducts');
            /** Unset paper id to remove from cart */
            if(($key = array_search($request->paper_id, $cartProducts)) !== false) {
                unset($cartProducts[$key]);
            }
            /** Update the cart session */
            session()->put('cartProducts', $cartProducts);
            /** Update cart calculations */
            $this->updateCouponCalculations($cartProducts,$mockProducts);
            /** Total of cart */
            $total = $this->helper->cartSubTotal($cartProducts);
            /** Get discount */
            $discount = $this->cartHelper->getCouponDiscount();
            /** Get code */
            $code = $this->cartHelper->getCouponCode();
            /** Check if applied for discount or not */
            if($discount) {
                $coupon = $this->helper->findByCouponCode($code);
                /** check of total is less then or equal to coupon discount amount */
                if ($total <= $coupon->amount_1) {
                    /** Flush coupon sessions */
                    $this->helper->flushCouponSessions();
                }
            } else {
                /** Flush coupon sessions */
                $this->helper->flushCouponSessions();
            }
            /** Redirect to cart page */
            return Redirect::route('cart')->with('message', Lang::get('frontend.cart.your_paper_removed_from_cart'));
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Clear Cart                                          |
     * |                                                     |
     * | @return Redirect                                    |
     * -------------------------------------------------------
     */
    public function clearCart()
    {
        try{
            /** Flush all cart sessions */
            $this->helper->flushAllCartSessions();
            /** Redirect to cart page */
            return Redirect::route('cart');
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Update Coupon Calculations                          |
     * |                                                     |
     * | @param @cartProducts                                |
     * -------------------------------------------------------
     */
    public function updateCouponCalculations($cartProducts,$mockProducts)
    {
        try{
            /** Get coupon code */
            $code = $this->cartHelper->getCouponCode();
            /** Check if code found or not */
            if($code) {
                /** Find coupon code details */
                $coupon = $this->helper->findByCouponCode($code);
                if (@$coupon) {
                    /** Get cart subtotal */
                    $paperSubTotal = $this->helper->cartSubTotal($cartProducts);
                    $mockSubTotal = $this->helper->mockCartSubTotal($mockProducts);

                    $total = $mockSubTotal + $paperSubTotal;
                    // Check if total is above amount 1 & below amount 2
                    if ($total > $coupon->amount_1 && $total < $coupon->amount_2) {
                        $discount = $this->helper->couponCalculation($total,$coupon->discount_1);
                    } else if($total > $coupon->amount_2) {
                        $discount = $this->helper->couponCalculation($total,$coupon->discount_2);
                    }
                    /** Forget discount session */
                    session()->forget('emock_coupon_discount');
                    if(isset($discount)) {
                        /** Format discount amount */
                        session()->put('emock_coupon_discount', number_format((float)$discount, 2, '.', ''));
                    }
                }
            }
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | E-Mock Cart Page                                    |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function eMockCart()
    {
        try{
            $cartItems = Cart::whereParentId(Auth::guard('parent')->id())->get();
            foreach($cartItems as $item){
                if($item->mock_test_id != null){
                    if($item->mockTest == null){
                        $item->delete();
                    }
                }
                if($item->paper_id != null){
                    if($item->paper == null){
                        $item->delete();
                    }
                }
            }
            $cartItems = Cart::whereParentId(Auth::guard('parent')->id())->get();
            Cart::whereParentId(Auth::guard('parent')->id())
                ->whereHas('mockTest',function($q){
                    $q->whereStatus('0');
                })->delete();
            Cart::whereParentId(Auth::guard('parent')->id())
                ->whereHas('paper',function($q){
                    $q->whereStatus(0);
                })->delete();
            /** Get all cart papers */
            $cartPapers = Cart::whereParentId(Auth::guard('parent')->id())->pluck('paper_id');
            /** Get related papers */
            $relatedPapers = $this->paperHelper->getCartRelatedProducts($cartPapers);

            /** Get all cart mocks */
            $mockProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('mock_test_id');
            /** Get related mocks */
            $relatedProducts = $this->mockTestHelper->getCartRelatedProducts($mockProducts);
            /** Get cart sub total */

            $cartSubTotal = Cart::whereParentId(Auth::guard('parent')->id())->sum('price');
            /** Get total coupon discount */
            $couponTotalDiscount = $this->cartHelper->getEmockCouponDiscount();
            $total = $cartSubTotal;
            /** Check if applied for discount */
            if($couponTotalDiscount) {
                /** Substract discount from cart subtotal */
                $amt = $cartSubTotal - $couponTotalDiscount;

                /** Format the final total */
                $total = $this->helper->numberFormat($amt,2);

                /** Check if coupon applied changed or not */
                $sessionCode = session()->get('emock_coupon_code');

                /** Find promo code details using applied coupon */
                $coupon = $this->helper->findByCouponCode($sessionCode);

                /** Get web settings details */
                $webSetting = getWebSettings();
                /** Remove coupon from session */
                if($coupon == null || @$webSetting->code_status == 0) {
                    $this->helper->flushCouponSessions();
                    $couponTotalDiscount = "";
                }
            }
            $promoCode = PromoCode::whereStatus(1)
                        ->whereDate('start_date', '<=', date("Y-m-d"))
                        ->whereDate('end_date', '>=', date("Y-m-d"))
                        ->first();
            if($promoCode == null){
                $this->helper->flushEmockCouponSessions();
            }
            $checkoutProducts = Cart::whereParentId(Auth::guard('parent')->id())->get();
            return view('newfrontend.orders.cart',['coupon'=>@$coupon,'checkoutProducts' => @$checkoutProducts,
            'relatedProducts' => @$relatedProducts,'cartSubTotal' => @$cartSubTotal,'couponDiscount' => @$couponTotalDiscount,
            'total' => @$total,'promoCode'=>@$promoCode,'relatedPapers'=>@$relatedPapers]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function eMockAddToCart(Request $request){
        $cartProducts = 0;
        $mockProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('mock_test_id')->toArray();
        $paperProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('paper_id')->toArray();
        if($request->paper_id != null){
            $paper = Paper::whereId($request->paper_id)->first();
            $orderIds = Order::whereParentId(Auth::guard('parent')->id())->pluck('id');
            // $orderItems = OrderItem::whereIn('order_id',$orderIds)->wherePaperId($request->paper_id)->count();
            // if($orderItems > 0){
            //     return response()->json(['error' => __('frontend.cart.paper_already_purchased')]);
            // }
            if ($paperProducts && in_array($request->paper_id,$paperProducts)) {
                return response()->json(['error' => Lang::get('frontend.cart.this_paper_is_already_added_to_cart')]);
            } else if(@$paper && $paper->status == 0 || $paper->deleted_at != null || $paper->category->status == 0 ) {
                return response()->json(['error' => __('frontend.paper_no_longer_available_msg')]);
            }else{
                $cart = Cart::create([
                        'paper_id'=>$request->paper_id,
                        'parent_id'=>Auth::guard('parent')->id(),
                        'price' => $paper->price,
                        ]);
            }
            $msg = __('frontend.cart.paper_added');
        }else{
            $mockTest = MockTest::whereId($request->mock_id)->first();
            $orderIds = Order::whereParentId(Auth::guard('parent')->id())->pluck('id');
            $orderItems = OrderItem::whereIn('order_id',$orderIds)->whereMockTestId($request->mock_id)->count();
            if($orderItems > 0){
                return response()->json(['error' => __('frontend.cart.mock_already_purchased')]);
            }
            /** Check if paper is already added into cart or not */
            if ($mockProducts && in_array($request->mock_id,$mockProducts)) {
                return response()->json(['error' => __('frontend.cart.mock_test_exits')]);
            } else if(@$mockTest && $mockTest->status == 0 || $mockTest->deleted_at != null ) {
                return response()->json(['error' => __('frontend.test_not_found')]);
            } else {
                $mockProducts[] = $request->mock_id;
                /** Put papers ids into session */
                // session()->put('mockCartProducts', $mockProducts);
                $cart = Cart::create([
                        'mock_test_id'=>$request->mock_id,
                        'parent_id'=>Auth::guard('parent')->id(),
                        'price' => $mockTest->price,
                        ]);
                /** Update the coupon calculations */

            }
            $msg = __('frontend.cart.mock_added');
        }
        $total = Cart::whereParentId(Auth::guard('parent')->id())->sum('price');
        /** Update the coupon calculations */
        $this->reCalculateCouponCode($total);

        $cartProducts = Cart::whereParentId(Auth::guard('parent')->id())->count();
        return response()->json(['total' => $cartProducts,'msg'=>$msg]);
    }


    /**
     * -------------------------------------------------------
     * | Remove papers from cart                             |
     * |                                                     |
     * | @param Request $request                             |
     * | @return Redirect                                    |
     * -------------------------------------------------------
     */
    public function removeExamFromCart(Request $request)
    {
        try{
            if($request->mock_id != null){
                Cart::whereParentId(Auth::guard('parent')->id())->whereMockTestId($request->mock_id)->delete();
            }
            if($request->paper_id != null){
                Cart::whereParentId(Auth::guard('parent')->id())->wherePaperId($request->paper_id)->delete();
            }
            $paperProducts = session()->pull('cartProducts', []);
            /** Unset paper id to remove from cart */
            if(($key = array_search($request->paper_id, $paperProducts)) !== false) {
                unset($paperProducts[$key]);
            }
            session()->put('cartProducts', $paperProducts);
            $mockProducts = session()->pull('mockCartProducts', []); /** Pull all cart papers from session */
            if(($key = array_search($request->mock_id, $mockProducts)) !== false) { /** Unset paper id to remove from cart */
                unset($mockProducts[$key]);
            }
            session()->put('mockCartProducts', $mockProducts); /** Update the cart session */
            $total = Cart::whereParentId(Auth::guard('parent')->id())->sum('price');
            /** Update the coupon calculations */
            $this->reCalculateCouponCode($total);

            return redirect()->route('emock-cart')->with('message', __('frontend.cart.exam_removed')); /** Redirect to cart page */
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Clear Cart                                          |
     * |                                                     |
     * | @return Redirect                                    |
     * -------------------------------------------------------
     */
    public function clearEmockCart()
    {
        try{
            /** Flush all cart sessions */
            session()->forget('mockCartProducts');
            session()->forget('emock_coupon_discount');
            session()->forget('emock_coupon_code');
            $this->helper->flushAllCartSessions();
            Cart::whereParentId(Auth::guard('parent')->id())->delete();
            /** Redirect to cart page */
            return Redirect::route('emock-cart');
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
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
            $code = $request->code; /** get code from request */
            $total = $request->total; /** get total from request */
            $msgType = 'error';
            if (@$request->type == 'apply') { // Check if apply code or remove code
                $coupon = $this->helper->findByCouponCode($code); /** Find promo code details using applied coupon */
                $webSetting = getWebSettings(); /** Get web settings details */
                if (@$coupon && @$coupon->status == 1 && @$webSetting->code_status == 1) { /** Check if coupon is active or not */
                    if ($total <= $coupon->amount_1) { // Check if total is less then or equal to amount 1
                        $msg = 'The minimum spend for this coupon is '. config('constant.default_currency_symbol').$coupon->amount_1.'.' ;
                    } else {
                        /** Discount caluclations */
                        $discount = $this->helper->couponCalculation($total,$coupon->discount_2);
                        /** Check if total is above amount 1 & below amount 2 */
                        if ($total > $coupon->amount_1 && $total < $coupon->amount_2) {
                            /** Discount caluclations */
                            $discount = $this->helper->couponCalculation($total,$coupon->discount_1);
                        }
                        session()->put('emock_coupon_discount', number_format((float)$discount, 2, '.', '')); /** Store coupon discount into session */
                        session()->put('emock_coupon_code',$request->code); /** Store coupon code into session */
                        $msg = Lang::get('frontend.coupon.coupon_code_applied_success_msg'); /** Set suceess message */
                        $msgType = 'success';
                    }
                } else {
                    $msg = Lang::get('frontend.coupon.code_does_not_exist',['type' => $code]); /** set error message */
                }
            } else { // Remove coupon code
                $this->helper->flushEmockCouponSessions(); /** Remove coupon from session */
                $msg = Lang::get('frontend.coupon.coupon_has_been_removed'); /** set error message */
                $msgType = 'success';
            }
            return Redirect::route('emock-cart')->with($msgType, $msg); /** Redirect to cart page */
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
     /**
     * -------------------------------------------------------
     * | Re calculate coupon code                            |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function reCalculateCouponCode($total){
        $code = session()->get('emock_coupon_code');
        $coupon = $this->helper->findByCouponCode($code);
        if($coupon){
            $discount = $this->helper->couponCalculation($total,$coupon->discount_2);
            /** Check if total is above amount 1 & below amount 2 */
            if ($total > $coupon->amount_1 && $total < $coupon->amount_2) {
                /** Discount caluclations */
                $discount = $this->helper->couponCalculation($total,$coupon->discount_1);
            }
            session()->put('emock_coupon_discount', number_format((float)$discount, 2, '.', '')); /** Store coupon discount into session */
            session()->put('emock_coupon_code',$code); /** Store coupon code into session */
        }
    }

    /**
     * -------------------------------------------------------
     * | Check that product is alreadypurchased  or not      |
     * |                                                     |
     * | @param Request $request                             |
     * | @return Redirect                                    |
     * -------------------------------------------------------
     */
    public function checkProductIsPurchased(Request $request){
        $cartProducts = 0;
        $paperProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('paper_id')->toArray();
        if($request->paper_id != null){
            $paper = Paper::whereId($request->paper_id)->first();
            $orderIds = Order::whereParentId(Auth::guard('parent')->id())->pluck('id');
            $orderItems = OrderItem::whereIn('order_id',$orderIds)->wherePaperId($request->paper_id)->count();
            if($orderItems > 0){
                return response()->json(['icon'=>'info','msg' =>__('frontend.cart.paper_already_purchased')]);
            }
            if ($paperProducts && in_array($request->paper_id,$paperProducts)) {
                return response()->json(['icon'=>'info','msg' => Lang::get('frontend.cart.this_paper_is_already_added_to_cart')]);
            }
            return response()->json(['icon'=>'success','msg'=>'']);
        }
    }

}
