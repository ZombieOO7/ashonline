<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PaymentSettingHelper;
use App\Http\Requests\Admin\PaymentSettingFormRequest;

class PaymentSettingController extends BaseController
{
    private $helper;
    public function __construct(PaymentSettingHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');

    }
    /**
     * -------------------------------------------------
     * | Store Payment Setting details                 |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(PaymentSettingFormRequest $request, $id = null)
    {
        try {
            $this->helper->store($request);
            $message = __('formname.web_setting.success_msg');
            return redirect()->route('web_setting_index')->with(['active_tab'=> @$request->active_tab,'message'=>@$message]);
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }
}
