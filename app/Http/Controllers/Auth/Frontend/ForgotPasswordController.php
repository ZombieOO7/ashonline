<?php

namespace App\Http\Controllers\Auth\Frontend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\SendsPasswordResetEmails;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Models\EmailTemplate;
use App\Models\ParentUser;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:parent');
    }

    public function showLinkRequestForm()
    {
        return view('frontend.parent-auth.email');
    }

    //Password Broker for Seller Model
    public function broker()
    {
        return Password::broker('parents');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:parents',
        ]);

        $token = Str::random(60);

        DB::table('parents_password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );
        $user = ParentUser::where('email',$request->email)->first();
        $this->sendMailToUser($request->email,$token,$user);

        return response()->json(['msg' => 'We have e-mailed your password reset link! ', 'icon' => 'success']);
        // return back()->with('message', 'We have e-mailed your password reset link!');
    }


       /**
 * ------------------------------------------------------
 * | Send Mail to Parent & Admin                        |
 * |                                                    |
 * |-----------------------------------------------------
 */
function sendmail($view, $data, $message=null, $subject, $userdata)
{
    Mail::send($view, $data, function ($message) use ($userdata, $subject) {
        $message->to($userdata)->subject($subject);
        
    });
  
}


/*
* -------------------------------------------------------
* | Send Email To Admin                                 | 
* |                                                     |
* | @param $details                                     |
* -------------------------------------------------------
*/
function sendMailToUser($email,$token,$user)
{
   try {
        $slug = config('constant.email_template.10');
        $template = EmailTemplate::whereSlug($slug)->first();
        $subject = $template->subject;
        $view = 'newfrontend.parent.reset-mail';
        $this->sendMail($view, ['token' => @$token,'resetPassword' => true,'content' => @$template->body,'user'=>@$user], null, $subject, $email);
        return __('formname.order_email_label');
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

}
