<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\ChildRegisterFormRequest;
use Auth;
use Carbon\Carbon;
use DB, Hash;
use Illuminate\Support\Str;
use Redirect;
use App\Models\Schools;
use App\Models\Student;
use App\Models\ExamBoard;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Models\ParentAddress;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ChildProfileUpdateFormRequest;
use App\Http\Requests\Frontend\ParentProfileUpdateFormRequest;
use App\Models\Order;
use App\Models\ParentPayment;
use App\Models\ParentUser;
use App\Models\Subscription;
use PDF;
use Exception;
use Mail;

class UserController extends BaseController
{
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
     * -------------------------------------------------------
     * | Parent Sign Up Form                                 |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function parentSignUpForm()
    {
        return view('newfrontend.parent.sign_up');
    }

    /**
     * -------------------------------------------------------
     * | Parent Profile Form                                 |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function profile()
    {
        if(Auth::guard('parent')->user() != null){
            $data['countryList'] = DB::table('countries')->orderBy('name','asc')->pluck('name','id');
            $data['user'] = Auth::guard('parent')->user();
            $data['parentAddress'] = ParentAddress::whereParentId(@$data['user']->id)->orderBy('id','asc')->first();
            $data['subscriptionStatusList'] = @config('constant.subscriptionStatus');
            return view('newfrontend.user.my_profile',$data);
        } else {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | Parent Profile Update                               |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function updateProfile(ParentProfileUpdateFormRequest $request)
    {
        $this->dbStart();
        try {
            if (Auth::guard('parent')->user() != null) {
                $user = Auth::guard('parent')->user();

                if ($request->file('image')) {
                    $uploadFunction = commonUpload($request->file('image'), config('constant.user_profile_folder'), $user->id);
                    array_set($request, 'profile_pic', @$uploadFunction[0]);
                }
                if ($request->new_password != null && $request->password_confirmation != null && $request->new_password != $request->password_confirmation) {
                    return Redirect::route('parent-profile')->with('error', __('frontend.PROFILE.PASSWORD_NOT_MATCHED'));
                } else {
                    if($request->new_password != null){
                        array_set($request, 'password', $request->new_password);
                        $details = ['subject' => 'Password Updated'];
                        $this->sendMailToUser($details, $user);
                    }
                }
                // check is subscription status was changed
                if($user->subscription_status != $request->subscription_status){
                    if($request->subscription_status == '1'){
                        array_set($request, 'subscription_start_date', date('Y-m-d'));
                        $this->storeParentSubscriptionInfo($request,$user);
                    }else{
                        array_set($request, 'subscription_cancel_date', date('Y-m-d'));
                    }
                }
                $user->update($request->all());
                $this->dbCommit();
                return Redirect::route('parent-profile')->with('success', __('frontend.PROFILE.UPDATED'));
            } else {
                abort('404');
            }
        } catch (Exception $e) {
            $this->dbRollBack();
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------------
     * | Child Profile Form                                  |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function childProfile()
    {
        if (Auth::guard('parent')->user() != null) {
            $user = Auth::guard('parent')->user();
            $students = Student::with('school')->orderBy('id','asc')->whereParentId($user->id)->get();
            $examBoardList = ExamBoard::orderBy('id','asc')->get();
            if ($students) {
                $examType = $this->examType();
                $examStyle = $this->mergeSelectOption(config('constant.exam_style'), __('formname.exam_style'));
                return view('newfrontend.user.child_profile', ['examBoardList'=>@$examBoardList,'students' => $students, 'examType' => @$examType, 'examStyle' => @$examStyle]);
            } else {
                return Redirect::route('parent-profile')->with('error', __('frontend.PROFILE.CHILD.NOT_FOUND'));
            }
        } else {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | Add Child Profile Form                              |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function newChildAdd($parentId)
    {
        $examTypes = $this->examType();
        $examStyles = $this->mergeSelectOption(config('constant.exam_style'), __('formname.exam_style'));
        $parents = ParentUser::whereUuid($parentId)->first();
        $examBoardList = ExamBoard::orderBy('id','asc')->get();
        $child = Student::where('parent_id', $parents->id)->get()->toArray();
        if (count($child) < 2) {
            return view('newfrontend.user.new_child', ['parent_id' => $parents->id,'examBoardList'=>@$examBoardList,
                'examType' => @$examTypes, 'examStyle' => @$examStyles]);
        } else {
            return Redirect::route('child-profile')->with('error', __('frontend.PROFILE.CHILD.MAXIMUM'));
        }


    }

    /**
     * -------------------------------------------------------
     * | Store Child data                                    |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function newChildRegister(ChildRegisterFormRequest $request)
    {
        $this->dbStart();
        try {
            $msg = __('formname.child_added');
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
            $mail = $this->sendMailToUser($parent->email,$token,$parent);
            $this->dbCommit();
            return Redirect::route('child-profile')->with('success', $msg);
        } catch (Exception $e) {
            $this->dbRollBack();
            abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | Exam Type                                           |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function examType()
    {
        $examType = ExamBoard::pluck('title', 'id');
        return @$this->mergeSelectOption($examType->toArray(), __('formname.test_papers.exam_type'));
    }

    /**
     * -------------------------------------------------------
     * | Merge Select option list.                           |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function mergeSelectOption($a, $type)
    {
        return ['' => __('formname.select_type', ['type' => @$type])] + $a;
    }

    /**
     * -------------------------------------------------------
     * | Update Child Profile                                |
     * | @param Request $request                             |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function updateChildProfile(ChildProfileUpdateFormRequest $request)
    {
        $this->dbStart();
        try {
            $user = Student::find($request->id);
            if ($request->file('image')) {
                $uploadFunction = commonUpload($request->file('image'), config('constant.child_profile_folder'), $user->id);
                array_set($request, 'profile_pic', @$uploadFunction[0]);
            }

            $school = Schools::whereSchoolName($request->school_name)->first();
            if ($school == null) {
                $school = Schools::create(['school_name' => $request->school_name, 'categories' => $request->exam_board_id]);
            }
            array_set($request, 'school_id', $school->id);
            // Change Password
            if (isset($request->new_password) && trim($request->new_password) != "" && isset($request->password_confirmation) && trim($request->password_confirmation) != "") {
                if($request->new_password != $request->password_confirmation) {
                    return Redirect::route('child-profile')->with('error',__('frontend.PROFILE.PASSWORD_NOT_MATCHED'));
                } else {
                    array_set($request,'password',$request->new_password);
                    array_set($request,'child_password',$request->new_password);
                }
            }
            $user->update($request->all());
            // update examboards
            $user->examBoards()->delete();
            if($request->exam_board_id){
                $data = [];
                foreach($request->exam_board_id as $key => $examBoardId){
                    $data[$key]['exam_board_id'] = (int)$examBoardId;
                }
                $user->examBoards()->createMany($data);
            }
            $this->dbCommit();
            return Redirect::route('child-profile')->with('success', __('frontend.PROFILE.CHILD.UPDATED'));
        } catch (Exception $e) {
            $this->dbRollBack();
            abort('404');
        }
    }


    /**
     * -------------------------------------------------------
     * | Student Profile Form                                 |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function studentProfile()
    {
        if (Auth::guard('student')->user() != null) {
            $user = Auth::guard('student')->user();
            $boardIds = $user->examBoards->pluck('exam_board_id');
            $examBoardName ='';
            if($boardIds){
                $studnetExamBoards = ExamBoard::whereIn('id',$boardIds)->pluck('title');
                $examBoardName = implode(',',$studnetExamBoards->toArray());
            }
            return view('newfrontend.child.my_profile', ['user' => $user,'examBoardName'=>@$examBoardName]);
        } else {
            abort('404');
        }
    }
 
    /**
     * ------------------------------------------------------
     * | Send Mail to User                                  |
     * |                                                    |
     * |-----------------------------------------------------
     */
    function sendmail($view, $data, $message = null, $subject, $userdata)
    {
        Mail::send($view, $data, function ($message) use ($userdata, $subject) {
            $message->to($userdata->email)->subject($subject);

        });


    }

    /**
    * -------------------------------------------------------
    * | Send Email To Parent                                |
    * |                                                     |
    * | @param User                                         |
    * -------------------------------------------------------
    */
    function sendMailToUser($details, $userdata)
    {

        try {
            $slug = config('constant.email_template.8');
            $template = EmailTemplate::whereSlug($slug)->first();
            $subject = $template->subject;
            $userdata = $userdata;
            $username = $userdata->full_name;
            $view = 'newfrontend.email_templates.updatePassword';

            $this->sendMail($view, ['username' => $username, 'content' => $template->body], null, $subject, $userdata);
            return __('formname.order_email_label');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
    * -------------------------------------------------------
    * | Store Parent subscription info                      |
    * |                                                     |
    * | @param $request, $user                              |
    * -------------------------------------------------------
    */
    public function storeParentSubscriptionInfo($request,$user){
        $subscription = Subscription::first();
        $date = date('Y').'-'.date('m').'-'.$subscription->payment_date;
        $paymentDate = date('Y-m-d', strtotime($date));
        // check if current day is greter than payment day
        if(date('d') > $subscription->payment_date){
            $paymentDate = date('Y-m-d', strtotime('+1 month', strtotime($date)));
            array_set($request, 'subscription_end_date', date('Y-m-d',strtotime($paymentDate)));
        }else{
            array_set($request, 'subscription_end_date', date('Y-m-d',strtotime('+1 month',strtotime($paymentDate))));
        }
        array_set($request, 'subscribed_at', date('Y-m-d'));
        array_set($request,'payment_date',$paymentDate);
        array_set($request,'subscription_id',$subscription->id);
        $user->lastSubscription()->create($request->all());
        $user->update(['subscription_end_date' => $paymentDate, 'subscription_id'=>$subscription->id]);
        return $user;
    }

    /**
    * -------------------------------------------------------
    * | Get Order lisitng                                   |
    * |                                                     |
    * | @return View                                        |
    * -------------------------------------------------------
    */
    public function invoiceDetail($uuid){
        try{
            $order = Order::where('uuid',$uuid)->first();
            return view('newfrontend.user.invoice_detail',['order'=>@$order]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
    * -------------------------------------------------------
    * | Download Order Invoice                              |
    * |                                                     |
    * | @return File                                        |
    * -------------------------------------------------------
    */
    public function downloadInvoice($uuid){
        try{
            $data['order'] = Order::where('uuid',$uuid)->first();
            $data['userdata'] = $data['order']->biilingAddress;
            $data['billingInfo'] = onlyAddress($data['order']->biilingAddress2->toArray());
            $view = 'admin.orders._pdf';
            $pdf = PDF::loadView($view, $data);
            $pdf->setPaper('A4', 'Landscape');
            return $pdf->download('invoice.pdf');
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
    * -------------------------------------------------------
    * | View  Invoice Detail                                |
    * |                                                     |
    * | @return View                                        |
    * -------------------------------------------------------
    */
    public function paymentInvoiceDetail($id){
        try{
            $payment = ParentPayment::where('id',$id)->first();
            return view('newfrontend.user.payment_invoice_detail',['payment'=>@$payment]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
    * -------------------------------------------------------
    * | Download Subscription Payment Invoice Detail        |
    * |                                                     |
    * | @return View                                        |
    * -------------------------------------------------------
    */
    public function downloadPaymentInvoice($id){
        try{
            $data['payment'] = ParentPayment::where('id',$id)->first();
            $data['userdata'] = $data['payment']->parent;
            $data['billingInfo'] = onlyAddress($data['userdata']->toArray());
            $view = 'admin.orders._invoice';
            $pdf = PDF::loadView($view, $data);
            $pdf->setPaper('A4', 'Landscape');
            return $pdf->download('invoice.pdf');
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
