<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Carbon\Carbon;
use App\Models\Cart;
use PayPal\Api\Item;
use App\Models\Order;
use App\Models\Paper;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use App\Models\MockTest;
use PayPal\Api\ItemList;
use App\Models\OrderItem;
use App\Models\PromoCode;
use App\Helpers\CartHelper;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use App\Helpers\OrderHelper;
use App\Helpers\PaperHelper;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use App\Models\ParentAddress;
use App\Models\BillingAddress;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Helpers\PaymentSettingHelper;
use App\Models\NotificationOrderItem;
use App\Models\Payment as ModelsPayment;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use Srmklive\PayPal\Services\ExpressCheckout;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaypalController extends Controller
{
    private $helper, $cartHelper, $notify;
    public $provider,$token;
    private $_api_context;

    public function __construct(OrderHelper $helper,PaperHelper $paperHelper,CartHelper $cartHelper, NotificationOrderItem $notify,PaymentSettingHelper $paymentSettingHelper)
    {
        $this->helper = $helper;
        $this->paperHelper = $paperHelper;
        $this->cartHelper = $cartHelper;
        $this->helper->mode = config('constant.frontend');
        $this->notify = $notify;
        $this->provider = new ExpressCheckout;
        $this->paymentSettingHelper = $paymentSettingHelper;
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    /**
     * -------------------------------------------------------
     * | Create Order Request                                |   
     * |                                                     |
     * | @param Request $request                             |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function createOrderRequest(Request $request)
    {
        try {
            $orderRequest = new OrdersCreateRequest();
            $orderRequest->prefer('return=representation');
            $paymentSetting = $this->paymentSettingHelper->paymentDetail();
            $orderRequest->body = self::buildRequestBody($request,$paymentSetting);
            $environment = new SandboxEnvironment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_SANDBOX_API_SECRET')); /** set sandbox environment using client & secret keys */
            $client = new PayPalHttpClient($environment);
            $response = $client->execute($orderRequest);
            return @$response->result->id;
        } catch (\HttpException $ex) {
            return response()->json(['error' => true, 'msg' => $ex->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------------
     * | Build Request Body                                  |   
     * |                                                     |
     * | @param $request                                     |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    private function buildRequestBody($request,$paymentSetting)
    {
        $cartAmount = Cart::whereParentId(Auth::guard('parent')->id())->sum('price');
        $amt = $cartAmount;

        // $product = session()->get('cartProducts'); /** Get cart products from session */
        // $total = Paper::whereIn("id",$product)->sum('price'); /** Get sum of all cart products */
        $amount = $this->helper->numberFormat($amt, 2); /** Format the total amount */
        $discount = session()->get('emock_coupon_discount'); /** Get discount value from session */
        if ($discount) { /** Check if discount found or not */
            $amt = $amount - $discount;
            $amount = $this->helper->numberFormat($amt, 2);
        }

        /** Create an array with payment related informations */
        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => route('payment.success'),
                    'cancel_url' => route('payment.cancel')
                ),
            'purchase_units' => 
                array( 0 => 
                    array(
                        'description' => __('frontend.paper_purchased'),
                        'amount' => array(
                                'value' => $amount,
                                "currency_code" => __('frontend.stripe_currency'),
                            ),
                    )
                ),
        );
    }

    /**
     * -------------------------------------------------------
     * | Approve Order Request                               |   
     * |                                                     |
     * | @param Request $request                             |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function approveOrderRequest(Request $request)
    {
        $orderId = $request->order_id; /** Get order id from request */
        $paymentSetting = $this->paymentSettingHelper->paymentDetail();

        $environment = new SandboxEnvironment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_SANDBOX_API_SECRET')); /** set sandbox environment using client & secret keys */
        $client = new PayPalHttpClient($environment); /** set paypal http client using environment */
        $response = $client->execute(new OrdersGetRequest($orderId)); /** get orders request using order id */

        if($response->result->status == config('constant.APPROVED')) { /** Check if payment status is approved or not */
            try {
                $requestCapture = new OrdersCaptureRequest($orderId); /** Check if payment status is approved or not */
                $captureResponse = $client->execute($requestCapture); /** Execute request capture */
                if($captureResponse->result->status == config('constant.COMPLETED')) {  /** Check if capture status is completed or not */

                    $this->helper->dbStart();
                    $cartAmount = Cart::whereParentId(Auth::guard('parent')->id())->sum('price');
                    $amt = $cartAmount;
                    // $cartProducts = $this->helper->getCartAllProducts(); /** Get cart products from session */
                    // $amt = $this->helper->cartSubTotal($cartProducts); /** Get sum of all cart products */
                    $amount = $this->helper->numberFormat($amt, 2); /** Format the total amount */
                    $discount = $this->cartHelper->getEmockCouponDiscount(); /** Get discount value from session */
                    $invoiceNo = $this->helper->getNextInvoiceNumber(); /** Get next invoice number */
                    $orderNo = $this->helper->getNextOrderNumber(); /** Get next order number */
                    $sessionCouponCode = session()->get('coupon_code'); /** Get applied coupon code stored in session */

                    /** Get applied promo code details */
                    $promoCode = PromoCode::whereCode($sessionCouponCode)->first();

                    /** Store Order */
                    $orderData = ['order_no'=>$orderNo,'amount'=> $amount, 'discount'=> $discount ? $discount : 0.00, 'invoice_no'=> $invoiceNo,'promo_code_id' => @$promoCode->code != null ? @$promoCode->id : null];
                    $order = $this->storeOrder($orderData);

                    /** Store Billing Address  */
                    $billingAddress = $this->storeBillingAddress($request->all(),$order);

                    /** Notify Result */
                    $this->notifyResult();

                    /** Store payment information */
                    $transactionId = @$captureResponse->result->purchase_units[0]->payments->captures[0]->id;
                    $paymentData = [ 'order_id' => $order->id, 'currency' => config('constant.default_currency_symbol'), 'amount' => $amount,'payment_date' => now(),'method' => 1,'transaction_id' => $transactionId];
                    $this->storePayments($paymentData);

                    $paperProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('paper_id');
                    $mockProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('mock_test_id');
                    /** Store Order Items */
                    // $this->storeOrderItems($cartProducts,$order,$billingAddress);
                    $this->storeEmockOrderItems($mockProducts, $order, $billingAddress);
                    $this->storeOrderItems($paperProducts, $order, $billingAddress);

                    /** Send order email to user */
                    $this->helper->sendMailToUser($order->id);

                    /** Send order email to admin */
                    $this->helper->sendMailToAdmin($order);

                    $this->helper->dbEnd();
                    $this->helper->flushAllCartSessions();
                    Cart::whereParentId(Auth::guard('parent')->id())->delete();
                    return ['success' => 1,'uuid' => $order->uuid];
                }
            } catch (\HttpException $ex) {
                $this->helper->dbRollBack();
                return response()->json(['error' => true, 'msg' => $ex->getMessage()]);
            }
        }
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
        return $order;
    }

    /**
     * -------------------------------------------------------
     * | Store Billing Addresses                             |   
     * |                                                     |
     * -------------------------------------------------------
     */
    public function storeBillingAddress($request,$order) 
    {
        $billingAddress = new BillingAddress;
        data_set($request,'order_id',$order->id);
        $billingAddress->fill($request)->save();
        return $billingAddress;
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
        if($notifyResult) {
            if(Carbon::today()->gt($notifyResult->created_at)) {
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
    public function storeOrderItems($cartProducts,$order,$billingAddress) 
    {
        // Store Order Items
        foreach($cartProducts as $key => $val) {
            if($val != null){
                $item =  new OrderItem;
                $paper = Paper::whereId($val)->first();
                $item->create([ 'order_id' => $order->id, 'paper_id' => $val, 'price' =>  $paper->price]);

                // Notification order items
                $this->notify->create([ 'order_id' => $order->id, 'paper_id' => $val, 'user_id' => $billingAddress->id ]);
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
        $payment = new ModelsPayment();
        $payment->fill($paymentData)->save();
        return @$payment;
    }

    /**
     * -------------------------------------------------------
     * | Create Order Request                                |
     * |                                                     |
     * | @param Request $request                             |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function createMockOrderRequest(Request $request)
    {
        try {
            $orderRequest = new OrdersCreateRequest();
            $orderRequest->prefer('return=representation');
            $paymentSetting = $this->paymentSettingHelper->paymentDetail();
            $orderRequest->body = self::buildMockRequestBody($request,$paymentSetting);
            $environment = new SandboxEnvironment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_SANDBOX_API_SECRET')); /** set sandbox environment using client & secret keys */
            $client = new PayPalHttpClient($environment);
            $response = $client->execute($orderRequest);
            return @$response->result->id;
        } catch (\HttpException $ex) {
            return response()->json(['error' => true, 'msg' => $ex->getMessage()]);
        }
    }


    /**
     * -------------------------------------------------------
     * | Approve Order Request                               |
     * |                                                     |
     * | @param Request $request                             |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function approveMockOrderRequest(Request $request)
    {
        $orderId = $request->order_id; /** Get order id from request */
        $paymentSetting = $this->paymentSettingHelper->paymentDetail();

        $environment = new SandboxEnvironment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_SANDBOX_API_SECRET')); /** set sandbox environment using client & secret keys */
        $client = new PayPalHttpClient($environment); /** set paypal http client using environment */
        $response = $client->execute(new OrdersGetRequest($orderId)); /** get orders request using order id */

        if($response->result->status == config('constant.APPROVED')) { /** Check if payment status is approved or not */
            try {
                $requestCapture = new OrdersCaptureRequest($orderId); /** Check if payment status is approved or not */
                $captureResponse = $client->execute($requestCapture); /** Execute request capture */
                if($captureResponse->result->status == config('constant.COMPLETED')) {  /** Check if capture status is completed or not */

                    $this->helper->dbStart();
                    // $cartProducts = $this->helper->getMockCartAllProducts(); /** Get cart products from session */
                    // $amt = $this->helper->mockCartSubTotal($cartProducts); /** Get sum of all cart products */

                    $cartAmount = Cart::whereParentId(Auth::guard('parent')->id())->sum('price');
                    $amt = $cartAmount;

                    $amount = $this->helper->numberFormat($amt, 2); /** Format the total amount */
                    $discount = $this->cartHelper->getEmockCouponDiscount(); /** Get discount value from session */
                    $invoiceNo = $this->helper->getNextInvoiceNumber(); /** Get next invoice number */
                    $orderNo = $this->helper->getNextOrderNumber(); /** Get next order number */
                    $sessionCouponCode = session()->get('coupon_code'); /** Get applied coupon code stored in session */

                    /** Get applied promo code details */
                    $promoCode = PromoCode::whereCode($sessionCouponCode)->first();

                    /** Store Order */
                    $orderData = ['order_no'=>$orderNo, 'parent_id' => Auth::guard('parent')->id(), 'amount'=> $amount, 'discount'=> $discount ? $discount : 0.00, 'invoice_no'=> $invoiceNo,'promo_code_id' => @$promoCode->code != null ? @$promoCode->id : null];
                    $order = $this->storeOrder($orderData);
                    $parent = Auth::guard('parent')->user();

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

                    /** Store payment information */
                    $transactionId = @$captureResponse->result->purchase_units[0]->payments->captures[0]->id;
                    $paymentData = [ 'order_id' => $order->id, 'currency' => config('constant.default_currency_symbol'), 'amount' => $amount,'payment_date' => now(),'method' => 1,'transaction_id' => $transactionId];
                    $this->storePayments($paymentData);

                    $paperProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('paper_id');
                    $mockProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('mock_test_id');
                    /** Store Order Items */
                    // $this->storeOrderItems($cartProducts,$order,$billingAddress);
                    $this->storeEmockOrderItems($mockProducts, $order, $billingAddress);
                    $this->storeOrderItems($paperProducts, $order, $billingAddress);

                    /** Send order email to user */
                    $this->helper->sendMailToUser($order->id);

                    /** Send order email to admin */
                    $this->helper->sendMailToAdmin($order);
                    $this->helper->flushAllCartSessions();
                    $this->helper->flushCouponSessions();
                    $this->helper->flushEmockCouponSessions();        
                    $this->helper->dbEnd();
                    Cart::whereParentId(Auth::guard('parent')->id())->delete();
                    return ['success' => 1,'uuid' => $order->uuid];
                }
            } catch (\HttpException $ex) {
                $this->helper->dbRollBack();
                return response()->json(['error' => true, 'msg' => $ex->getMessage()]);
            }
        }
    }


    /**
     * -------------------------------------------------------
     * | Build Request Body                                  |
     * |                                                     |
     * | @param $request                                     |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    private function buildMockRequestBody($request,$paymentSetting)
    {
        $cartAmount = Cart::whereParentId(Auth::guard('parent')->id())->sum('price');
        $amt = $cartAmount;

        $amount = $this->helper->numberFormat($amt, 2); /** Format the total amount */
        $discount = $this->cartHelper->getEmockCouponDiscount(); /** Get discount value from session */

        if ($discount) { /** Check if discount found or not */
            $amt = $amount - $discount;
            $amount = $this->helper->numberFormat($amt, 2);
        }

        /** Create an array with payment related informations */
        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => route('payment.success'),
                    'cancel_url' => route('payment.cancel')
                ),
            'purchase_units' =>
                array( 0 =>
                    array(
                        'description' => __('frontend.paper_purchased'),
                        'amount' => array(
                            'value' => $amount,
                            "currency_code" => __('frontend.stripe_currency'),
                        ),
                    )
                ),
        );
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
     * | Post payment with paypal                            |
     * |                                                     |
     * | @param questionId                                   |
     * | @return response                                    |
     * -------------------------------------------------------
     */

    public function postPaymentWithpaypal(Request $request)
    {
        $totalAmount = $this->checkoutAmount();
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

    	$item_1 = new Item();

        $item_1->setName('Purchase paper')
            ->setCurrency('GBP')
            ->setQuantity(1)
            ->setPrice($totalAmount);

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('GBP')
            ->setTotal($totalAmount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Purchase paper');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('paypal-status'))
            ->setCancelUrl(URL::route('paypal-status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                return Redirect::route('emock-checkout')->with('error','Connection timeout');
            } else {
                return Redirect::route('emock-checkout')->with('error','Some error occur, sorry for inconvenient');
            }
        }
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        Session::put('paypal_payment_id', $payment->getId());
        if(isset($redirect_url)) {
            return Redirect::away($redirect_url);
        }
        \Session::put('error','Unknown error occurred');
    	return Redirect::route('emock-checkout');
    }
   /**
     * -------------------------------------------------------
     * | Get payment status                                  |
     * |                                                     |
     * | @param questionId                                   |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function getPaymentStatus(Request $request)
    {
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            \Session::put('error','Payment failed');
            return Redirect::route('emock-checkout');
        }
        $payment = Payment::get($payment_id, $this->_api_context);        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            $this->helper->dbStart();
            $cartAmount = Cart::whereParentId(Auth::guard('parent')->id())->sum('price');
            $amt = $cartAmount;
            // $cartProducts = $this->helper->getCartAllProducts(); /** Get cart products from session */
            // $amt = $this->helper->cartSubTotal($cartProducts); /** Get sum of all cart products */
            $amount = $this->helper->numberFormat($amt, 2); /** Format the total amount */
            $discount = $this->cartHelper->getEmockCouponDiscount(); /** Get discount value from session */
            $invoiceNo = $this->helper->getNextInvoiceNumber(); /** Get next invoice number */
            $orderNo = $this->helper->getNextOrderNumber(); /** Get next order number */
            $sessionCouponCode = session()->get('coupon_code'); /** Get applied coupon code stored in session */

            /** Get applied promo code details */
            $promoCode = PromoCode::whereCode($sessionCouponCode)->first();

            /** Store Order */
            $orderData = ['order_no'=>$orderNo,'amount'=> $amount, 'discount'=> $discount ? $discount : 0.00, 'invoice_no'=> $invoiceNo,'promo_code_id' => @$promoCode->code != null ? @$promoCode->id : null];
            $order = $this->storeOrder($orderData);

            /** Store Billing Address  */
            $billingAddress = $this->storeBillingAddress($request->all(),$order);

            /** Notify Result */
            $this->notifyResult();

            /** Store payment information */
            // $transactionId = @$captureResponse->result->purchase_units[0]->payments->captures[0]->id;
            $paymentData = [ 'order_id' => $order->id, 'currency' => config('constant.default_currency_symbol'), 'amount' => $amount,'payment_date' => now(),'method' => 1,'transaction_id' => $payment_id];
            $this->storePayments($paymentData);

            $paperProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('paper_id');
            $mockProducts = Cart::whereParentId(Auth::guard('parent')->id())->pluck('mock_test_id');
            /** Store Order Items */
            // $this->storeOrderItems($cartProducts,$order,$billingAddress);
            $this->storeEmockOrderItems($mockProducts, $order, $billingAddress);
            $this->storeOrderItems($paperProducts, $order, $billingAddress);

            /** Send order email to user */
            $this->helper->sendMailToUser($order->id);

            /** Send order email to admin */
            $this->helper->sendMailToAdmin($order);
            $this->helper->dbEnd();
            $this->helper->flushAllCartSessions();
            Cart::whereParentId(Auth::guard('parent')->id())->delete();
            return Redirect::route('emock-thank-you',['uuid' => $order->uuid]);
        }else{
            return Redirect::route('emock-checkout')->with('error','Payment failed !!');
        }
    }

        /**
     * -------------------------------------------------------
     * | E-Mock Checkout Page                                |    
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function checkoutAmount()
    {
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
            /** Coupon total discount */
            $couponTotalDiscount = $this->cartHelper->getEmockCouponDiscount();
            if ($couponTotalDiscount) {
                $amt = $total - $couponTotalDiscount;
                $total = $this->helper->numberFormat($amt, 2);
            }
            return @$total;
        }else{
            return null;
        }
    }
}
