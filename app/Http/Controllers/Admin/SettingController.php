<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingFormRequest;
use App\Models\PaymentSetting;
use App\Models\WebSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public $constant, $activetab;
    public function __construct()
    {
        $this->activetab = config('constant')['websetting']['active_tab'];
    }
    /**
     * -------------------------------------------------
     * | Display Web Setting page                      |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index(Request $request,$activeTab=null)
    {
        $settings = [];
        $settings = WebSetting::first();
        $paymentSetting = PaymentSetting::first();
        return view('admin.setting.index',['activeTab'=>@$activeTab,'setting'=>@$settings,'paymentSetting'=>@$paymentSetting]);
    }
    /**
     * -------------------------------------------------
     * | Store Setting details                         |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(SettingFormRequest $request, $id = null)
    {
        try {
            $inputs = Input::except('_token', 'id');
            $currentPath = Route::currentRouteName();
            $settings = WebSetting::firstOrNew(['id' => $id]);
            // check if request has logo file
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $inputs['logo'] = $this->fileupload($logo, ($settings->logo) ? $settings->logo : null);
            }
            // check if request has favicon file
            if ($request->hasFile('favicon')) {
                $favicon = $request->file('favicon');
                $inputs['favicon'] = $this->fileupload($favicon, ($settings->logo) ? $settings->favicon : null);
            }
            $settings->fill($inputs)->save();
            $message = trans('formname.web_setting.success_msg');
            return Redirect::route('web_setting_index',['active_tab'=>@$request->active_tab])->with('message',$message);
            // ['message'=>@$message,'active_tab'=>@$request->active_tab]
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }
    /**
     * -------------------------------------------------
     * | File Upload                                   |
     * |                                               |
     * | @param File,name                              |
     * | @return Variable                              |
     * |------------------------------------------------
     */
    public function fileupload($file, $name = null)
    {
        // check if name is not null
        if ($name != null) {
            Storage::disk('local')->delete('websetting/' . $name);
        }
        $filename = time() . '_' . $file->getClientOriginalName();
        Storage::disk('local')->putFileAs('websetting/', $file, $filename);
        return @$filename;
    }
}
