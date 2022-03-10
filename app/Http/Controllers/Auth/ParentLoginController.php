<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Exception;
use App\Models\Schools;
use App\Models\Student;
use App\Models\ExamBoard;
use App\Models\ParentUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Frontend\ParentFormRequest;
use App\Http\Requests\Frontend\ChildRegisterFormRequest;
use App\Models\EmailTemplate;
use App\Models\Subscription;
use Carbon\Carbon;

class ParentLoginController extends Controller
{
    protected $redirectTo = '/exam';

    public function __construct()
    {
        $this->middleware('guest:parent', ['except' => ['logout']]);
        $this->middleware('guest:student', ['except' => ['logout']]);
    }


    /*
     * -------------------------------------------------------
     * | Begine Transaction.                                 |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function dbStart()
    {
        return DB::beginTransaction();
    }

    /*
     * -------------------------------------------------------
     * | Commit Transaction.                                 |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function dbCommit()
    {
        return DB::commit();
    }

    /**
     * -------------------------------------------------------
     * | RollBack Transaction.                               |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function dbRollBack()
    {
        return DB::rollback();
    }

    /**
     * This is function is use for login form view.
     */
    public function showLoginForm()
    {
        $route = 'parent.login.post';
        return view('frontend.parent-auth.login',['route'=>@$route,'title'=>'Parent Login']);
    }

    /**
     * This function is used for login process.
     *
     * @param Request $request
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
        ]);
        $url = url()->previous();
        // check if login user is parent
        if($request->type == 'parent'){
            // check user credentials
            if (Auth::guard('parent')->attempt(['email' => strtolower($request->email), 'password' => $request->password])) {
                $parent = Auth::guard('parent')->user();
                // check parent is verified or active 
                if(Auth::guard('parent')->user()->is_verify == 1 && Auth::guard('parent')->user()->status == 1 || Auth::guard('parent')->user()->status == 2 ){
                    $newSessionId = Str::random(30);
                    session()->put('user_session_id', $newSessionId);
                    Auth::guard('parent')->user()->update(['session_id' => $newSessionId]);
                    $msg = __('formname.login_success');
                    return response()->json(['msg' => @$msg, 'icon' => 'success','type'=>'parent','url'=>@$url]);
                }else{
                    // send verify link to parent
                    $tokenData = DB::table('parents_password_resets')->where(['email' => $parent->email])->orderBy('created_at','desc')->first();
                    $mail = $this->sendMailToUser($parent->email,$tokenData->token,$parent);
                    Auth::guard('parent')->logout();
                    $msg = __('formname.login_success');
                    return response()->json(['msg' => 'Your account is not verified, Please verify your email account from mail.', 'icon' => 'error']);
                }
            }
        }
        if($request->type == 'child'){
            if (Auth::guard('student')->attempt(['email' => $request->username, 'password' => $request->password])) {
                $student = Auth::guard('student')->user();
                $parent = ParentUser::find($student->parent_id);
                // check that parent is verified or active 
                if($parent->is_verify == 1 && $parent->status == 1){
                    // check child is verified or active 
                    if($student->active == 1){
                        $newSessionId = Str::random(30);
                        session()->put('user_session_id', $newSessionId);
                        Auth::guard('student')->user()->update(['session_id' => $newSessionId]);
                        $msg = __('formname.login_success');
                        return response()->json(['msg' => @$msg, 'icon' => 'success','type'=>'student']);
                    }else{
                        Auth::guard('student')->logout();
                        $msg = __('formname.login_success');
                        return response()->json(['msg' => 'Your account is not verified.', 'icon' => 'error']);
                    }
                }else{
                    Auth::guard('student')->logout();
                    return response()->json(['msg' => 'Your parent account is not verified or Inactive.', 'icon' => 'error']);
                }
            }
        }
        return response()->json(['msg' => 'These credentials do not match with our records.', 'icon' => 'error']);
    }

    /**
     * This function is used for login process.
     *
     * @param Request $request
     * @return View
     */
    public function logout(Request $request)
    {
        if(Auth::guard('parent')->user()!=null){
            Auth::guard('parent')->user()->update(['session_id' => NULL]);
            Auth::guard('parent')->logout();
            session()->put('user_session_id',NULL);
        }
        if(Auth::guard('student')->user()!=null){
            Auth::guard('student')->user()->update(['session_id' => NULL]);
            Auth::guard('student')->logout();
            session()->put('user_session_id',NULL);
            // session()->flush();
        }
        return redirect()->route('firstpage');
    }


    /**
     * This is function is use for login form view.
     */
    public function parentSignUpForm()
    {
        $countryList = DB::table('countries')->orderBy('name','asc')->pluck('name','id');
        return view('newfrontend.parent.sign_up',['countryList'=>@$countryList]);
    }

    /**
     * store parent registration form detail.
     */
    public function register(ParentFormRequest $request)
    {
        $this->dbStart();
        try {
            $msg = __('formname.parent.regirstation_success');
            $parent = new ParentUser();
            // store parent subscription info
            $subscription = Subscription::first();
            array_set($request,'subscription_id',$subscription->id);
            $parent->fill($request->all())->save();
            $this->dbCommit();
            return Redirect::route('child-sign-up',['parentId'=>$parent->uuid])->with('message', $msg);
        } catch (Exception $e) {
            $this->dbRollBack();
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * Child signup form.
     *
     * @param $parentId
     * @return View
     */
    public function childSignUpForm($parentId=null){
        $examType = $this->examType();
        $examStyle = $this->mergeSelectOption(config('constant.exam_style'),__('formname.exam_style'));
        $parent = ParentUser::whereUuid($parentId)->first();
        $examBoardList = ExamBoard::orderBy('id','asc')->get();
        return view('newfrontend.child.sign_up',['examBoardList'=>@$examBoardList,'parent_id'=>$parent->id,'examType'=>@$examType,'examStyle'=>@$examStyle]);
    }

    /**
     * store student data .
     *
     * @param Request $request
     * @return View
     */
    public function childRegister(ChildRegisterFormRequest $request){
        $this->dbStart();
        try {
            $msg = __('formname.registration_verify');
            // find or create school
            $school = Schools::whereSchoolName($request->school_name)->first();
            if($school == null){
                $school = Schools::create(['school_name'=>$request->school_name]);
            }
            $student = new Student();
            $studentNumber = generateStudentNo();
            array_set($request,'student_no',$studentNumber);
            array_set($request,'dob',date('Y-m-d',strtotime($request->dob)));
            array_set($request,'school_id',$school->id);
            array_set($request,'email',$request->username);
            array_set($request,'child_password',$request->password);
            $student->fill($request->all())->save();
            $data = [];
            foreach($request->exam_board_id as $key => $examBoardId){
                $data[$key]['exam_board_id'] = (int)$examBoardId;
            }
            $student->examBoards()->createMany($data);
            $parent = ParentUser::find($student->parent_id);
            $token = Str::random(60);

            DB::table('parents_password_resets')->insert(
                ['email' => $parent->email, 'token' => $token, 'created_at' => Carbon::now()]
            );

            $this->sendMailToUser($parent->email,$token,$parent);
            $this->dbCommit();
            return Redirect::route('firstpage')->with('success', $msg);
        } catch (Exception $e) {
            $this->dbRollBack();
            abort('404');
        }
    }

    /**
     * ------------------------------------------------------
     * | Send Mail to Parent & Admin                        |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function sendmail($view, $data, $message=null, $subject, $userdata)
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
    public function sendMailToUser($email,$token,$parent)
    {
        try {
            $slug = config('constant.email_template.11');
            $template = EmailTemplate::whereSlug($slug)->first();
            $subject = $template->subject;
            $view = 'newfrontend.parent.verify';
            $this->sendMail($view, ['token' => $token,'content' => $template->body,'user'=>$parent], null, $subject, $email);
            return __('formname.order_email_label');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /*
    * -------------------------------------------------------
    * | Get exam boards                                     |
    * |                                                     |
    * | @return Array                                       |
    * -------------------------------------------------------
    */
    public function examType(){
        $examType = ExamBoard::pluck('title','id');
        return @$this->mergeSelectOption($examType->toArray(),__('formname.test_papers.exam_type'));
    }

    /**
     * -------------------------------------------------------
     * | Merge Select option list.                           |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function mergeSelectOption($a,$type)
    {
        return  ['' => __('formname.select_type',['type'=>@$type])]+$a;
    }

    /**
     * -------------------------------------------------------
     * | Verify user account.                                |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function verifyMail($token)
    {
        $this->dbStart();
        try {
            $parentUser = DB::table('parents_password_resets')->where(['token' => $token])->first();
            if($parentUser){
                $parent = ParentUser::where('email', $parentUser->email)
                            ->update(['is_verify' => 1]);
                $token = DB::table('parents_password_resets')->where(['token' => $token])->delete();
                $this->dbCommit();
                $parent = ParentUser::whereEmail($parentUser->email)->first();
                $child = Student::whereParentId($parent->id)->first();
                $email = 'child'.$child->student_no;
                $slug = config('constant.email_template.12');
                $template = EmailTemplate::whereSlug($slug)->first();
                $subject = $template->subject;
                $password = $child->child_password;
                // send child credential mail
                Mail::send('newfrontend.child.login_detail',['user'=>@$child,'content' => $template->body,'email' => @$email,'password'=>@$password], function($message) use ($parent,$subject) {
                    $message->to($parent->email);
                    $message->subject($subject);
                });
                // $msg = __('formname.student.regirstation_success');
                return redirect()->route('parent-thank-you');
            }else{
                return Redirect::route('firstpage')->with('error', 'Invalid token!');
            }
        } catch (Exception $e) {
            $this->dbRollBack();
                abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | Thank you pages.                                    |
     * |                                                     |
     * | return View                                         |
     * -------------------------------------------------------
     */
    public function thankYou(){
        return view('newfrontend.parent.thank_you');
    }

    /**
     * -------------------------------------------------------
     * | Check that user is already login.                   |
     * |                                                     |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function checkUserlogin(Request $request){
        if($request->type == 'parent'){
            $user = Parentuser::where(['email'=>$request->email,'is_verify'=>1])->where('status','!=',0)->first();
        }else{
            $user = Student::where('email',$request->username)->where('active',1)->first();
            if($user != NULL){
                $parent = ParentUser::where(['id'=>$user->parent_id,'is_verify'=>1,'status'=>1])->first();
                if($parent != NULL){
                    $user = NULL;
                }
            }
        }
        $newSessionId = session()->get('user_session_id');
        if($user != NULL && $user->session_id != NULL) {
            if($newSessionId != $user->session_id){
                return response()->json(['status'=>'info','msg'=>__('formname.already_login')]);
            }
        }
        return response()->json(['status'=>'success','msg'=>'']);
    }

}
