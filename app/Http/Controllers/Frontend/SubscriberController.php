<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SubscribeHelper;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use Newsletter;

class SubscriberController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $helper;
    public function __construct(SubscribeHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.frontend');
    }

    // For store subscriber to mailchimp
    public function store(Request $request) 
    {
        $this->helper->dbStart();
        try {
            if ($request->ajax()) {
                $rules = ['email' => 'required|email'];
                $validator = \Validator::make($request->all(),$rules); 
                if ($validator->fails()) {
                    return response()->json([ 'error'=> $validator->errors()->first() ]);
                }
                $isSubscribe = Newsletter::isSubscribed($request->email);
                if($isSubscribe) {
                    return response()->json(['msg' => __('admin_messages.sub_already', ['email' => $request->email]), 'icon' => 'info']);
                }
                Newsletter::subscribeOrUpdate($request->email);
                // $this->helper->dbEnd();
                return response()->json(['msg' => __('admin_messages.sub_confirm'), 'icon' => 'success']);
            }
        } catch(\Exception $e) {
            return response()->json(['msg' => __('admin_messages.sub_fail'), 'icon' => 'error']);
            $this->helper->dbRollBack();
        }
    }
}
