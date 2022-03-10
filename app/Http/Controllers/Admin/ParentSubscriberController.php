<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\BaseHelper;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\ParentPayment;
use App\Models\ParentSubscriber;
use App\Models\ParentSubscriptionInfo;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class ParentSubscriberController extends BaseController
{
    protected $subscribe,$parentPayment,$helper,$subscriberInfo;
    public $viewConstant = 'admin.parent-subscriber.';
    public function __construct(BaseHelper $helper, ParentSubscriber $subscribe,ParentPayment $parentPayment, ParentSubscriptionInfo $subscriberInfo)
    {
        $this->subscriberInfo = $subscriberInfo;
        $this->helper = $helper;
        $this->subscribe = $subscribe;
        $this->parentPayment = $parentPayment;
    }

    /**
     * -----------------------------------------------------
     * | Subscriber list                                   |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function index(Request $request)
    {
        $data = $this->statusList();
        return view($this->viewConstant.'index', ['statusList' => @$data]);
    }

    /**
     * -----------------------------------------------------
     * | Subscriber datatables data                        |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function getDatatable(Request $request)
    {
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        $itemQuery = $this->subscriberInfo->select('*');
        $count_total = $itemQuery->count();
        $itemQuery = $itemQuery->skip($start)->take($limit);
        $parents = $itemQuery->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return DataTables::of($parents)
            ->addColumn('action', function ($subscriber) {
                return $this->getPartials($this->viewConstant . '_add_action', ['subscriber' => @$subscriber]);
            })
            ->addColumn('checkbox', function ($subscriber) use ($request) {
                return $this->getPartials($this->viewConstant . '_add_checkbox', ['subscriber' => @$subscriber]);
            })
            ->editColumn('subscriber_id', function ($subscriber) {
                return @$subscriber->subscription->title;
            })
            ->editColumn('full_name', function ($subscriber) {
                return @$subscriber->parent->full_name;
            })
            ->addColumn('email', function ($subscriber) {
                return @$subscriber->parent->email;
            })
            ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
            ->rawColumns(['action', 'subscriber_id', 'parent_id', 'email', 'checkbox'])
            ->skipPaging()
            ->make(true);
    }

    /**
     * -----------------------------------------------------
     * | Subscriber payment list                           |
     * |                                                   |
     * | @param Request $request                           |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function show($parentId){
        $title = __('formname.payment.list');
        $deductMoney = $this->helper->monthlyDeduction();
        return view($this->viewConstant.'__detail', ['title'=>@$title,'parentId' => @$parentId]);
    }

    /**
     * -----------------------------------------------------
     * | Parent payment datatable                          |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function getPaymentDatatable(Request $request){
        try {
            $paymentList = $this->parentPayment->whereParentId($request->parent_id)->get();
            return Datatables::of($paymentList)
                ->editColumn('description', function ($payment) {
                    return $this->getPartials($this->viewConstant .'_add_message',['payment' => @$payment]);
                })
                ->editColumn('method', function ($payment) {
                    return $payment->method_text;
                })
                ->editColumn('created_at', function ($payment) {
                    return $payment->proper_payment_at;
                })
                ->editColumn('status', function ($payment) {
                    return $this->getPartials('admin.payment._add_status',['payment' => @$payment]);
                })
                ->addColumn('checkbox', function ($payment){
                    return $this->getPartials($this->viewConstant . '_add_payment_checkbox', ['payment' => @$payment]);
                })
                ->addColumn('action', function ($payment) {
                    return $this->getPartials($this->viewConstant . '_add_payment_action', ['payment' => @$payment]);
                })
                ->rawColumns(['action','checkbox','method', 'action', 'status', 'description'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -----------------------------------------------------
     * | Subscriber payment detail                         |
     * |                                                   |
     * | @param Request $request                           |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function paymentDetail($id){
        $title = __('formname.payment.list');
        $paymentDetail = $this->parentPayment->find($id);
        return view($this->viewConstant.'__payment_detail', ['title'=>@$title,'paymentDetail' => @$paymentDetail]);
    }

    /**
     * -----------------------------------------------------
     * | Subscriber payment detail                         |
     * |                                                   |
     * | @param Request $request                           |
     * | @return View                                      |
     * -----------------------------------------------------
    */
    public function sendInvoice(Request $request){
        $id = $request->id;
        $title = __('formname.payment.list');
        $paymentDetail = $this->parentPayment->find($id);
        $slug = config('constant.email_template.14');
        $template = EmailTemplate::whereSlug($slug)->first();
        $subject = $template->subject;
        $view = 'frontend.template.invoice';
        $userdata = $paymentDetail->parent;
        try{
            $this->sendMail($view, ['content'=>@$template->body,'paymentDetail'=>@$paymentDetail,'user'=>$userdata], null, $subject, $userdata);
            return response()->json(['status'=> 'success','message'=> __('formname.mail_sent')]);
        }catch(Exception $e){
            return response()->json(['status'=> 'info','msg'=> __('formname.general_error')]);
        }
    }
}
