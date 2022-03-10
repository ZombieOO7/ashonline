<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PaymentHelper;
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PaymentController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.payment.';
    public function __construct(PaymentHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * -------------------------------------------------
     * | Display Payment list                          |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $statusList = $this->paymentStatusList();
        return view($this->viewConstant . 'index', ['statusList' => @$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Get Payment datatable data                    |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $payments = $this->helper->paymentList();
            $paymentList = $payments->where(function ($query) use ($request) {
                // check if request has status
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            })->get();
            return Datatables::of($paymentList)
                ->addColumn('order_no', function ($payment) {
                    return $payment->order->order_no;
                })
                ->addColumn('action', function ($payment) {
                    return $this->getPartials($this->viewConstant .'_add_action',['payment' => $payment]);
                })
                ->editColumn('method', function ($payment) {
                    return $payment->method_text;
                })
                ->editColumn('created_at', function ($payment) {
                    return $payment->proper_payment_at;
                })
                ->editColumn('status', function ($payment) {
                    return $this->getPartials($this->viewConstant .'_add_status',['payment' => $payment]);

                })
                ->rawColumns(['method', 'action', 'order_no', 'status', 'created_at'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Get Payment detail                            |
     * |                                               |
     * | @param Request $uuid                          |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function show($uuid = null)
    {
        $payment = $this->helper->detail($uuid);
        return view($this->viewConstant . 'view', ['payment' => @$payment]);
    }
}
