<?php

namespace App\Http\Controllers\Frontend;

use App\Models\CMS;
use App\Models\Admin;
use App\Models\ContactUs;
use App\Helpers\BaseHelper;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\ContactUsFormRequest;
use Exception;

class ContactUsController extends BaseController
{
    private $helper;
    public function __construct(BaseHelper $helper, ContactUs $model, CMS $cmsModel)
    {
        $this->helper = $helper;
        $this->model = $model;
        $this->cmsModel = $cmsModel;
    }

    /**
     * -----------------------------------------------------
     * | Contact us page                                   |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function index()
    {
        try{
            // create captcha
            $captcha = $this->helper::createCaptcha();
            // Get contact subject list
            $subjectList = $this->contactUsSubjectList();
            $pageDetail = $this->cmsModel::wherePageSlug('contact-us')->firstOrFail();
            return view('frontend.contact-us.index', ['captcha' => @$captcha, 'subjectList' => @$subjectList, 'pageDetail' => @$pageDetail]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -----------------------------------------------------
     * | Store/Edit contact us form                        |
     * |                                                   |
     * | @param ContactUsFormRequest $request              |
     * | @return Redirect                                  |
     * -----------------------------------------------------
     */
    public function store(ContactUsFormRequest $request)
    {
        try{
            // Save contact us details
            $contact_us = new ContactUs();
            $msg = Lang::get('formname.contact_us_success');
            $contact_us->fill($request->all())->save();
            // Get admin record
            $admin = Admin::first();
            $email = $admin->email;
            $slug = config('constant.email_template_slugs.contact_us');
            // Get email template
            $template = $this->helper->emailTamplate($slug);
            $subject = $template->subject;
            $view = 'frontend.contact-us.__mail';
            // Set keywords
            $keywords = [
                '[USER_FULL_NAME]'=> $request->full_name,
                '[EMAIL]' => $request->email,
                '[PHONE]' => $request->phone,
                '[SUBJECT]' => $request->subject,
                '[MESSAGE]' => $request->message,
            ];
            // Replace keywords with content
            $keys = array_keys($keywords);
            $values = array_values($keywords);
            $content = str_replace($keys,$values, $template->body);
            // Send Email
            Mail::send($view, ['content'=> $content,'adminFullName'=>@$admin->fullname], function ($message) use ($subject, $email) {
                $message->from(env('MAIL_USERNAME'));
                $message->to($email)->subject($subject);
            });
            // redirect with message
            return Redirect::route('contact-us')->with('message', $msg);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -----------------------------------------------------
     * | refresh captcha image                             |
     * |                                                   |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function refreshCapatcha()
    {
        // return json response
        return response()->json(['success' => 'success', 'imagePath' => url(__('frontend.captcha_img_url')), 'captcha' => session()->get('captcha')]);
    }
}
