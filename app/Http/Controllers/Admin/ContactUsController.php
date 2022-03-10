<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Lang;
use Yajra\Datatables\Datatables;

class ContactUsController extends BaseController
{
    protected $viewConstant = 'admin.contact-us.';
    /**
     * -----------------------------------------------------
     * | Contact us list                                   |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function index()
    {
        return view($this->viewConstant.'index');
    }

    /**
     * -----------------------------------------------------
     * | Contact us datatables data                        |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function getdata(Request $request)
    {
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        $itemQuery = ContactUs::select('*');
        $count_total = $itemQuery->count();
        $itemQuery = $itemQuery->skip($start)->take($limit);
        $contact_us = $itemQuery->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return Datatables::of($contact_us)
            ->addColumn('action', function ($contact) {
                return $this->getPartials($this->viewConstant .'_add_action',['contact'=>@$contact]);
            })
            ->editColumn('email', function ($contact) {
                return $this->getPartials($this->viewConstant .'_add_email',['contact'=>@$contact]);
            })
            ->editColumn('message', function ($contact) {
                return $this->getPartials($this->viewConstant .'_add_message',['contact'=>@$contact]);
            })
            ->addColumn('checkbox', function ($contact) {
                return $this->getPartials($this->viewConstant .'_add_checkbox',['contact'=>@$contact]);
            })
            ->editColumn('created_at', function ($contact) {
                return $contact->proper_created_at;
            })
            ->with(["draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total, "recordsFiltered" => $count_filter])
            ->rawColumns(['created_at','checkbox', 'action', 'status', 'message', 'email'])
            ->skipPaging()
            ->make(true);
    }

    /**
     * -----------------------------------------------------
     * | Delete contact us record                          |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function destroyContactUs(Request $request)
    {
        // check is request has id or not
        if (isset($request->id)) {
            $contact = ContactUs::find($request->id);
            $contact->delete();
            return response()->json(['msg' => __('formname.action_msg',['type'=>'Inquiry','action'=>__('formname.deleted')]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => Lang::get('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * -----------------------------------------------------
     * | Multiple Delete contact us record                 |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function multideleteContactUs(Request $request)
    {
        ContactUs::whereIn('id', $request->ids)->delete();
        return response()->json(['msg' => Lang::get('formname.contact_us_delete'), 'icon' => __('admin_messages.icon_success')]);
    }
}
