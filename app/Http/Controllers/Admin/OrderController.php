<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\OrderHelper;
use App\Helpers\PdfHelper;
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class OrderController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.orders.';
    public function __construct(OrderHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
        $this->pdf2 = new PdfHelper();
    }

    /**
     * -------------------------------------------------
     * | Display Orders list                           |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $statusList = $this->orderStatusList();
        return view($this->viewConstant . 'index', ['statusList' => $statusList]);
    }

    /**
     * -------------------------------------------------
     * | Get orders datatable data                     |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $draw = intval($request->draw) + 1 ;
            $limit = @$request->length?? 10;
            $start = @$request->start ?? 0;
            $orders = $this->helper->orderList();
            $itemQuery = $orders->where(function ($query) use ($request) {
                // check if request has status
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $order_list = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return Datatables::of($order_list)
                ->addColumn('action', function ($order) {
                    return $this->getPartials($this->viewConstant .'_add_action',['order'=>@$order]);
                })
                ->editColumn('created_at', function ($order) {
                    return $order->proper_created_at;
                })
                ->editColumn('amount', function ($order) {
                    return $order->amount_text;
                })
                ->editColumn('discount', function ($order) {
                    return $order->discount_text;
                })
                ->editColumn('total', function ($order) {
                    return config('constant.default_currency_symbol') . @$order->total_amount;
                })
                ->editColumn('status', function ($order) {
                    return $this->getPartials($this->viewConstant .'_add_status',['order'=>@$order]);
                })
                ->with(["draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total, "recordsFiltered" => $count_filter])
                ->rawColumns(['discount', 'amount', 'action', 'status', 'created_at', 'total'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * ------------------------------------------------------
     * | Download orders medias                             |
     * |                                                    |
     * | @param $uuid                                       |
     * | @return Redirect                                   |
     * |-----------------------------------------------------
     */
    public function downloadMedia($uuid)
    {
        $file = $this->helper->detailByUuid($uuid);
        $userid = $file->id;
        $newPath = storage_path() . '/app/' . config('constant.paper.folder_name') . $userid . '/' . $file->pdf_name;
        $fileExist = file_exists($newPath);
        // check if file is exist or file path not empty
        if (!empty($file) && !empty($file->path) && $fileExist) {
            return $this->helper->forceToDownload($newPath);
        } else {
            return back()->with(['info' => Lang::get('formname.file_not_found')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Show Order details                            |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function show($uuid = null)
    {
        $order = $this->helper->detail($uuid);
        $billingInfo = $this->helper->onlyAddress($order->biilingAddress2->toArray());
        return view($this->viewConstant . 'view', ['order' => $order,'billingInfo'=>@$billingInfo]);
    }

    /**
     * -------------------------------------------------
     * | Download Paper by selceted version in order   |
     * | item listing page                             |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function downloadByVersion(Request $request)
    {
        try {
            $paperPath = null;
            $status = 'error';
            $versionPaper = $this->helper->downloadPaper($request->order_uuid, $request->paper_slug, $request->version_id);
            $paperId = ($versionPaper->paper_id==null)?$versionPaper->id:$versionPaper->paper_id;
            $path = config('constant.storage_path') . config('constant.paper.folder_name') . $paperId . '/download/' . $versionPaper->pdf_name;
            // check if file is exist or file path not empty
            if ($path != null && file_exists($path)){
                $status = __('admin_messages.icon_success');
                $paperPath = url($path);
            }
            return response()->json(['status' => @$status, 'path' => @$paperPath]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'path' => null]);
        }
    }


    /**
     * -------------------------------------------------------
     * | Send Email to user                                  |
     * |                                                     |
     * | @param $orderId                                     |
     * -------------------------------------------------------
     */
    public function sendMailUser(Request $request)
    {
        try {
            $orderId = $request->order_id;
            $paperId = $request->paper_id;
            $versionId = $request->version_id;
            $orderItem = $this->helper->getPaperOrder($orderId,$paperId);
            $slug = config('constant.email_template.6');
            $template = $this->helper->emailTamplate($slug);
            $subject = $template->subject;
            $userdata = $orderItem->order->biilingAddress;
            $billingInfo = $this->helper->onlyAddress($orderItem->order->biilingAddress2->toArray());
            $view = 'admin.orders.__resendmail';
            $this->helper->sendMail($view, ['billingInfo'=>@$billingInfo,'orderItem'=>@$orderItem, 'versionId'=>@$versionId ,'content'=>@$template->body], null, @$subject, @$userdata);
            return response()->json(['status' => __('admin_messages.icon_success')]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
