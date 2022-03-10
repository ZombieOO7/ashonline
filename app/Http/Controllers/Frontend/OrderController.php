<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\CartHelper;
use App\Helpers\OrderHelper;
use App\Helpers\PaperHelper;
use App\Helpers\PaymentSettingHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentFormRequest;
use App\Http\Requests\Frontend\EMockPaymentFormRequest;
use App\Models\BillingAddress;
use App\Models\Cart;
use App\Models\ParentAddress;
use App\Models\NotificationOrderItem;
use App\Models\Order;
use App\Models\MockTest;
use App\Models\OrderItem;
use App\Models\Paper;
use App\Models\Payment;
use App\Models\PromoCode;
use Carbon\Carbon;
use Exception;
use Lang;
use Stripe;
use Auth;

class OrderController extends Controller
{
    private $helper, $cartHelper, $notify;
    public $provider, $token;

    public function __construct(OrderHelper $helper, PaperHelper $paperHelper, CartHelper $cartHelper, NotificationOrderItem $notify, PaymentSettingHelper $paymentSettingHelper)
    {
        $this->helper = $helper;
        $this->paperHelper = $paperHelper;
        $this->cartHelper = $cartHelper;
        $this->helper->mode = config('constant.frontend');
        $this->notify = $notify;
        $this->paymentSettingHelper = $paymentSettingHelper;
    }

    /**
     * -------------------------------------------------------
     * | Show Checkout Page                                  |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function checkout()
    {
        /** Get all cart products */
        $cartProducts = $this->helper->getCartAllProducts(); 
        $papers = Paper::whereIn('id', $cartProducts)->withTrashed()->get();
        $titleArr = [];
        foreach ($papers as $paper) {
            if ($paper->status != 1 || $paper->deleted_at != null || $paper->category->status != 1) {
                $titleArr[] = $paper->title;
            }
        }
        $inactivePapers = implode(",", $titleArr);
        // check if count is greater then 0 or not
        if (count($titleArr) > 0) {
            return redirect()->back()->with('error', '" ' . $inactivePapers . ' "'.__('frontend.paper_is_your_cart_no_longer_msg'));
        }
        if ($cartProducts) {
            /** Get cart sub total */
            $amt = $this->helper->cartSubTotal($cartProducts);
            /** Format the total amount */
            $total = $this->helper->numberFormat($amt, 2); 
            /** Coupon total discount */
            $couponTotalDiscount = $this->cartHelper->getCouponDiscount(); 
            if ($couponTotalDiscount) {
                $amt = $total - $couponTotalDiscount;
                $total = $this->helper->numberFormat($amt, 2);
            }
            return view('frontend.orders.checkout', ['total' => @$total]);
        } else {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | Make Payment                                        |
     * |                                                     |
     * | @param Request $request                             |
     * -------------------------------------------------------
     */
    public function makePayment(PaymentFormRequest $request)
    {
        try{
            $paperProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('paper_id');
            $mockProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('mock_test_id');
            /** Get cart products from session */
            $cartProducts = $this->helper->getCartAllProducts(); 
            /** Get cart sub total */
            $amt = $this->helper->cartSubTotal($cartProducts); 
            /** Format the total amount */
            $amount = $this->helper->numberFormat($amt, 2); 
            /** Get discount value from session */
            $discount = $this->cartHelper->getCouponDiscount(); 
            /** Get next invoice number */
            $invoiceNo = $this->helper->getNextInvoiceNumber(); 
            /** Get next order number */
            $orderNo = $this->helper->getNextOrderNumber(); 
            /** Get applied coupon code stored in session */
            $sessionCouponCode = session()->get('coupon_code'); 
            $paymentSetting = $this->paymentSettingHelper->paymentDetail();
            /** Check request payment method is stripe or not */
            if ($request->payment_method == __('frontend.payment_method_stripe')) {
                $this->helper->dbStart();
                Stripe\Stripe::setApiKey($paymentSetting->stripe_secret??env('STRIPE_SECRET')); /** Set stripe API Key */
                try {
                    /** CHARGE STRIPE */
                    $charge = Stripe\Charge::create([
                        "amount" => $amount * 100,
                        "currency" => $paymentSetting->stripe_currency?? __('frontend.stripe_currency'),
                        "source" => $request->stripeToken,
                        "description" => Lang::get('frontend.payment.paper_purchased'),
                    ]);
                    /** Check if payment status is succeeded or not */
                    if ($charge->status == "succeeded") {
                        /** Get applied promo code details */
                        $promoCode = PromoCode::whereCode($sessionCouponCode)->first();
                        /** Store Order */
                        $orderData = ['order_no' => $orderNo,'parent_id' => Auth::guard('parent')->id(), 'amount' => $amount, 'discount' => $discount ? $discount : 0.00, 'invoice_no' => $invoiceNo, 'promo_code_id' => @$promoCode->code != null ? @$promoCode->id : null];
                        $order = $this->storeOrder($orderData);

                        /** Store Billing Address  */
                        $billingAddress = $this->storeBillingAddress($request->all(), $order);

                        /** Notify Result */
                        $this->notifyResult();

                        /** Store Order Items */
                        $this->storeOrderItems($paperProducts, $order, $billingAddress);
                        $this->storeEmockOrderItems($mockProducts, $order, $billingAddress);

                        /** Store payment information */
                        $paymentData = ['order_id' => $order->id, 'currency' => config('constant.default_currency_symbol'), 'amount' => $amount, 'payment_date' => now(), 'method' => 2, 'transaction_id' => $charge->id];
                        $this->storePayments($paymentData);

                        /** Send order email to user */
                        $this->helper->sendMailToUser($order->id);

                        /** Send order email to admin */
                        $this->helper->sendMailToAdmin($order);

                        $this->helper->dbEnd();
                        $this->helper->flushAllCartSessions();
                        return redirect()->route('thank_you', ['uuid' => $order->uuid]);
                    } else {
                        $this->helper->dbRollBack();
                        return back()->with(['error' => Lang::get('frontend.payment.payment_failed')]);
                    }
                } catch (\Stripe\Exception\CardException $e) { 
                    $this->helper->dbRollBack();
                    return back()->with(['error' => $e->getMessage()]); /** Invalid card details */
                } catch (\Stripe\Exception\RateLimitException $e) { 
                    $this->helper->dbRollBack();
                    return back()->with(['error' => $e->getMessage()]); /** Too many requests made to the API too quickly */
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    $this->helper->dbRollBack();
                    return back()->with(['error' => $e->getMessage()]); /** Invalid parameters were supplied to Stripe's API */
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    $this->helper->dbRollBack();
                    return back()->with(['error' => $e->getMessage()]); /** Authentication with Stripe's API failed */
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    $this->helper->dbRollBack();
                    return back()->with(['error' => $e->getMessage()]); /** Network communication with Stripe failed */
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $this->helper->dbRollBack();
                    return back()->with(['error' => $e->getMessage()]); /** Display a very generic error to the user, and maybe send */
                } catch (Exception $e) {
                    $this->helper->dbRollBack();
                    return back()->with(['error' => $e->getMessage()]); /** Something else happened, completely unrelated to Stripe */
                }
            }
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Download paper with watermark                       |
     * |                                                     |
     * | @param $orderId,$paperId                            |
     * | @return Response file                               |
     * -------------------------------------------------------
     */
    public function download($uuid, $slug, $version=null)
    {
        try {
            // Download paper
            $versionPaper = $this->helper->downloadPaper($uuid, $slug, $version);
            $paperId = ($versionPaper->paper_id==null)?$versionPaper->id:$versionPaper->paper_id;
            // Check if version paper is null or not
            if($versionPaper != null){
                $path = config('constant.storage_path') . config('constant.paper.folder_name') . $paperId . '/download/' . $versionPaper->pdf_name;
                // return response()->download(@$path,@$versionPaper->paper->slug.'.pdf');
                return response()->file(@$path);
            }
            abort('404');
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | Order Completed Thank You Page                      |
     * |                                                     |
     * | @param $uuid                                        |
     * -------------------------------------------------------
     */
    public function thankYou($uuid)
    {
        try {
            // get order
            $order = $this->helper->orderByUuid($uuid);
            // get order items
            $orderItems = OrderItem::whereOrderId($order->id)->get();
            // get billing address
            $billingAddress = BillingAddress::whereOrderId($order->id)->first();
            
            return view('frontend.orders.thank_you', ['order' => @$order, 'orderItems' => @$orderItems, 'billingAddress' => @$billingAddress]);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | Paypal cancel/failed                                |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function cancel()
    {
        return redirect()->route('checkout')->with(['error' => Lang::get('frontend.payment.payment_cancelled')]);
    }

    /**
     * -------------------------------------------------------
     * | Force Order Delete                                  |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function orderForceDelete($uuid)
    {
        Order::whereUuid($uuid)->forceDelete();
    }

    /**
     * -------------------------------------------------------
     * | Store Orders                                        |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function storeOrder($orderData)
    {
        $order = new Order;
        $order->fill($orderData)->save();
        return @$order;
    }

    /**
     * -------------------------------------------------------
     * | Store Billing Addresses                             |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function storeBillingAddress($request, $order)
    {
        $billingAddress = new BillingAddress;
        data_set($request, 'order_id', $order->id);
        $billingAddress->fill($request)->save();
        return @$billingAddress;
    }

    /**
     * -------------------------------------------------------
     * | Store parent Addresse                             |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function storeParentAddress($parentData)
    {
        $parentAddress = ParentAddress::create($parentData);
        return @$parentAddress;
    }

    /**
     * -------------------------------------------------------
     * | Notification                                        |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function notifyResult()
    {
        $notifyResult = $this->notify->orderBy('id', 'desc')->first();
        if ($notifyResult) {
            if (Carbon::today()->gt($notifyResult->created_at)) {
                $this->notify->whereNotNull('id')->delete();
            }
        }
    }

    /**
     * -------------------------------------------------------
     * | Store Order Items                                   |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function storeOrderItems($cartProducts, $order, $billingAddress)
    {
        // Store Order Items
        foreach ($cartProducts as $key => $val) {
            if($val != null){
                $item = new OrderItem;
                $paper = Paper::whereId($val)->first();
                $item->create(['order_id' => $order->id, 'paper_id' => $val, 'price' => $paper->price]);
                // Notification order items
                $this->notify->create(['order_id' => $order->id, 'paper_id' => $val, 'user_id' => $billingAddress->id]);
            }
        }
    }

    /**
     * -------------------------------------------------------
     * | Store Order Items                                   |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function storeEmockOrderItems($cartProducts, $order, $billingAddress)
    {
        // Store Order Items
        foreach ($cartProducts as $key => $val) {
            if($val != null){
                $item = new OrderItem;
                $mock = MockTest::whereId($val)->first();
                $item->create(['order_id' => $order->id, 'mock_test_id' => $val, 'price' => $mock->price]);
                // Notification order items
                $this->notify->create(['order_id' => $order->id, 'mock_test_id' => $val, 'user_id' => $billingAddress->id]);
            }
        }
    }

    /**
     * -------------------------------------------------------
     * | Store Payments                                      |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function storePayments($paymentData)
    {
        $payment = new Payment;
        $payment->fill($paymentData)->save();
        return @$payment;
    }

    /**
     * -------------------------------------------------------
     * | E-Mock Checkout Page                                |    
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function eMockCheckout()
    {
        try{
            /** Get all cart products */
            $paperProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('paper_id');
            $mockProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('mock_test_id');
            $papers = Paper::whereIn('id', $paperProducts)->withTrashed()->get();
            $mocks = MockTest::whereIn('id', $mockProducts)->withTrashed()->get();
            $titleArr = [];
            foreach ($papers as $paper) {

                if ($paper->status != 1 || $paper->deleted_at != null ) {
                    $titleArr[] = $paper->title;
                }
            }
            foreach ($mocks as $paper) {

                if ($paper->status != 1 || $paper->deleted_at != null ) {
                    $titleArr[] = $paper->title;
                }
            }
            $inactivePapers = implode(",", $titleArr);
            // check if count is greater then 0 or not
            if (count($titleArr) > 0) {
                return redirect()->back()->with('error', '" ' . $inactivePapers . ' "'.__('frontend.emock_is_your_cart_no_longer_msg'));
            }
            if ($mockProducts || $paperProducts) {

                $cartAmount = Cart::whereParentId(Auth::guard('parent')->id())->sum('price');
                $amt = $cartAmount;
                /** Format the total amount */
                $total = $this->helper->numberFormat($amt, 2);
                if($total == 0){
                    return redirect()->route('emock-cart');
                }
                /** Coupon total discount */
                $couponTotalDiscount = $this->cartHelper->getEmockCouponDiscount();
                if ($couponTotalDiscount) {
                    $amt = $total - $couponTotalDiscount;
                    $total = $this->helper->numberFormat($amt, 2);
                }
                $parentAddresses = ParentAddress::where('parent_id', Auth::guard('parent')->id())->orderBy('id','DESC')->get();
                return view('newfrontend.orders.checkout', ['total' => @$total,'parentAddresses'=>$parentAddresses]);
            } else {
                abort('404');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Order Completed Thank You Page                      |
     * |                                                     |
     * | @param $uuid                                        |
     * -------------------------------------------------------
     */
    public function eMockThankYou($uuid=null)
    {
        try{
            $order = $this->helper->orderByUuid($uuid);
            return view('newfrontend.orders.thank_you',['order'=>@$order]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    /**
     * -------------------------------------------------------
     * | Make Payment                                        |
     * |                                                     |
     * | @param Request $request                             |
     * -------------------------------------------------------
     */
    public function eMockmakePayment(EMockPaymentFormRequest $request)
    {
        /** Get all cart products */
        $paperProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('paper_id');
        $mockProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('mock_test_id');
        $papers = Paper::whereIn('id', $paperProducts)->withTrashed()->get();
        $mocks = MockTest::whereIn('id', $mockProducts)->withTrashed()->get();
        /** Get cart products from session */
        $cartAmount = Cart::whereParentId(Auth::guard('parent')->id())->sum('price');
        $amt = $cartAmount;
        /** Format the total amount */
        $amount = $this->helper->numberFormat($amt, 2);
        /** Get discount value from session */
        $discount = $this->cartHelper->getEmockCouponDiscount();
        /** Get next invoice number */
        $invoiceNo = $this->helper->getNextInvoiceNumber();
        /** Get next order number */
        $orderNo = $this->helper->getNextOrderNumber();
        /** Get applied coupon code stored in session */
        $sessionCouponCode = session()->get('emock_coupon_code');
        $paymentSetting = $this->paymentSettingHelper->paymentDetail();
        /** Check request payment method is stripe or not */

        if ($request->payment_method == __('frontend.payment_method_stripe')) {
            $this->helper->dbStart();
            Stripe\Stripe::setApiKey($paymentSetting->stripe_secret??env('STRIPE_SECRET')); /** Set stripe API Key */

             try {
                /** CHARGE STRIPE */
                $charge = Stripe\Charge::create([
                    "amount" => $amount * 100,
                    "currency" => $paymentSetting->stripe_currency?? __('frontend.stripe_currency'),
                    "source" => $request->stripeToken,
                    "description" => Lang::get('frontend.payment.paper_purchased'),
                ]);
                /** Check if payment status is succeeded or not */


                if ($charge->status == "succeeded") {
                    /** Get applied promo code details */
                    $promoCode = PromoCode::whereCode($sessionCouponCode)->first();
                    /** Store Order */
                    $orderData = ['order_no' => $orderNo, 'parent_id' => Auth::guard('parent')->id(), 'amount' => $amount, 'discount' => $discount ? $discount : 0.00, 'invoice_no' => $invoiceNo, 'promo_code_id' => @$promoCode->code != null ? @$promoCode->id : null];
                    $order = $this->storeOrder($orderData);
                    $parent = Auth::guard('parent')->user();
                    $parentAddress = ParentAddress::where('parent_id','=',@$parent->id)->first();
                    $billingData =  [
                        'email' => @$parent->email,
                        'phone' => @$parent->mobile,
                        'first_name' => @$parent->first_name,
                        'last_name' => @$parent->last_name,
                        'address1' => @$parent->address,
                        'address2' => @$parent->address2,
                        'city' => @$parent->city,
                        'postal_code' => @$parent->zip_code,
                        'state' => @$parent->state,
                        'country' => @$parent->getCountry->name,
                    ];
                    $billingAddress = $this->storeBillingAddress($billingData, $order);

                    /** Notify Result */
                    $this->notifyResult();

                    /** Store Order Items */
                    $this->storeEmockOrderItems($mockProducts, $order, $billingAddress);
                    $this->storeOrderItems($paperProducts, $order, $billingAddress);

                    /** Store payment information */
                    $paymentData = ['order_id' => $order->id ,'parent_id' => Auth::guard('parent')->id(), 'currency' => config('constant.default_currency_symbol'), 'amount' => $amount, 'payment_date' => now(), 'method' => 2, 'transaction_id' => $charge->id];
                    $this->storePayments($paymentData);

                    /** Send order email to user */
                    $this->helper->sendMailToUser($order->id);

                    /** Send order email to admin */
                    $this->helper->sendMailToAdmin($order);

                    $this->helper->dbEnd();
                    $this->helper->flushAllEmockCartSessions();
                    $this->helper->flushAllCartSessions();
                    Cart::whereParentId(Auth::guard('parent')->id())->delete();
                    return redirect()->route('emock-thank-you', ['uuid' => $order->uuid]);
                } else {
                    $this->helper->dbRollBack();
                    return back()->with(['error' => Lang::get('frontend.payment.payment_failed')]);
                }
             } catch (\Stripe\Exception\CardException $e) {
                 $this->helper->dbRollBack();
                 return back()->with(['error' => $e->getMessage()]); /** Invalid card details */
             } catch (\Stripe\Exception\RateLimitException $e) {
                 $this->helper->dbRollBack();
                 return back()->with(['error' => $e->getMessage()]); /** Too many requests made to the API too quickly */
             } catch (\Stripe\Exception\InvalidRequestException $e) {
                 $this->helper->dbRollBack();
                 return back()->with(['error' => $e->getMessage()]); /** Invalid parameters were supplied to Stripe's API */
             } catch (\Stripe\Exception\AuthenticationException $e) {
                 $this->helper->dbRollBack();
                 return back()->with(['error' => $e->getMessage()]); /** Authentication with Stripe's API failed */
             } catch (\Stripe\Exception\ApiConnectionException $e) {
                 $this->helper->dbRollBack();
                 return back()->with(['error' => $e->getMessage()]); /** Network communication with Stripe failed */
             } catch (\Stripe\Exception\ApiErrorException $e) {
                 $this->helper->dbRollBack();
                 return back()->with(['error' => $e->getMessage()]); /** Display a very generic error to the user, and maybe send */
             } catch (Exception $e) {
                 $this->helper->dbRollBack();
                 return back()->with(['error' => $e->getMessage()]); /** Something else happened, completely unrelated to Stripe */
             }
        }
    }
}
