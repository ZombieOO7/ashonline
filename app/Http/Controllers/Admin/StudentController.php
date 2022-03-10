<?php

namespace App\Http\Controllers\Admin;
use App\Models\Student;
use App\Models\ParentUser;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StudentRequest;
use App\Models\EmailTemplate;
use App\Models\ExamBoard;
use App\Models\Schools;
use App\Models\StudentExamBoard;
use Exception;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Lang;
use Hash;
use Illuminate\Support\Facades\Mail;

class StudentController extends BaseController
{

    protected $student;

    public function __construct(Student $student) {
        $this->student = $student;
    }

    /**
     * ---------------------------------------
     * | Display list of student             |
     * |                                     |
     * | @return View                        |
     * ---------------------------------------
     */
    public function index()
    {
        $statusList = $this->properStatusList();
        return view('admin.student.index',['statusList' => @$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Get student datatable                         |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getData(Student $Student,Request $request)
    {
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        $itemQuery = $this->student::orderBy('created_at', 'desc')
                    ->select('id','uuid','first_name','middle_name','last_name','dob','school_year','parent_id','student_no','active','created_at')
                    ->where(function ($query) use ($request) {
                        // check status is not null
                        if ($request->status) {
                            $query->activeSearch($request->status);
                        }
                    });
        $count_total = $itemQuery->count();
        $itemQuery = $itemQuery->skip($start)->take($limit);
        $student = $itemQuery->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return Datatables::of($student)
            ->addColumn('action', function ($student) {
                return \View::make('admin.student.action', ['student' => $student ,'type' => config('constant.col_action')])->render();
            })
            ->editColumn('created_at', function ($student) {
                return @$student->proper_created_at;
            })
            ->editColumn('active', function ($student) {
                return @$student->active_tag;
            })
            ->editColumn('dob', function ($student) {
                return @$student->dob_text;
            })
            ->editColumn('parent_name', function ($student) {
                return ucwords(@$student->parents->full_name);
            })
            ->editColumn('exam_board_id', function ($student) {
                $boardIds = $student->examBoards->pluck('exam_board_id');
                $examBoardName ='';
                if($boardIds){
                    $studnetExamBoards = ExamBoard::whereIn('id',$boardIds)->pluck('title');
                    $examBoardName = implode(',',$studnetExamBoards->toArray());
                }
                return $examBoardName;
            })
            ->addColumn('checkbox', function ($student) use ($request){
                return \View::make('admin.student.action', ['student' => $student, 'type' => config('constant.col_checkbox')])->render();
            })
            ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
            ->rawColumns([ 'exam_board_id','dob','action', 'created_at', 'checkbox', 'parent_name','active'])
            ->skipPaging()
            ->make(true);
    }

    /**
     * -------------------------------------------------
     * | Create student page                           |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create(Request $request)
    {
        $methodType = __('formname.student.student_create');
        $parentUser = ParentUser::orderBy('id')->get()->pluck('full_name_with_email', 'id');
        $examType = $this->boardList();
        $examStyle = $this->mergeSelectOption(config('constant.exam_style'),__('formname.exam_style'));
        $schoolList = Schools::pluck('school_name','id');
        $examBoardList = ExamBoard::orderBy('id','asc')->get();
        $statusList = $this->properStatusList();
        return view('admin.student.edit',['examBoardList'=>@$examBoardList,'schoolList'=>@$schoolList,'methodType'=>@$methodType , 
        'parentUser' => @$parentUser,'examType'=>@$examType,'examStyle'=>@$examStyle,'statusList'=>@$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Store student details                         |
     * |                                               |
     * | @param StudentRequest $request                |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(StudentRequest $request)
    {
        // dd($request->all());
        $studentNumber = $this->helper();
        array_set($request,'student_no',$studentNumber);
        $child = $this->student->create($request->all());
        $parent = ParentUser::find($request->parent_id);
        $child = Student::whereParentId($request->parent_id)->first();
        $email = $child->email;
        if($request->password == null){
            $request->request->remove('password');
        }else{
            $request->password = Hash::make('password');
        }
        $password = $child->child_password;
        $data = [];
        foreach($request->exam_board_id as $key => $examBoardId){
            $data[$key]['exam_board_id'] = (int)$examBoardId;
            $data[$key]['student_id'] = (int)$child->id;
        }
        $examboards = StudentExamBoard::insert($data);
        $slug = config('constant.email_template.12');
        $template = EmailTemplate::whereSlug($slug)->first();
        $subject = $template->subject;
        Mail::send('newfrontend.child.login_detail',['user'=>@$child,'content' => $template->body,'email' => @$email,'password'=>@$password], function($message) use ($parent,$subject) {
            $message->to($parent->email);
            $message->subject($subject);
        });
        return redirect()->route('student.index')->with('message',__('admin_messages.student.student_created_msg'));
    }

    /**
     * -------------------------------------------------
     * | Get student unqie number                      |
     * |                                               |
     * |                                               |
     * | @return int                                   |
     * |------------------------------------------------
     */
    public function helper() {
        $last = 1001;
        $lastStudent = $this->student::orderBy('id', 'desc')->withTrashed()->first();
        // check if student data found
        if($lastStudent) {
            $lastStudentId = $lastStudent->student_no;
            $newStudentNo = $lastStudentId + 1;
        } else {
            $newStudentNo = $last;
        }
        return @$newStudentNo;
    }

    /**
     * -------------------------------------------------
     * | Get student detail                            |
     * |                                               |
     * |                                               |
     * | @return view                                  |
     * |------------------------------------------------
     */
    public function show(Student $Student, $uuid)
    {
        $student = $this->student::whereUuid($uuid)->firstOrFail();
        $boardIds = $student->examBoards->pluck('exam_board_id');
        $examBoardName ='';
        if($boardIds){
            $studnetExamBoards = ExamBoard::whereIn('id',$boardIds)->pluck('title');
            $examBoardName = implode(',',$studnetExamBoards->toArray());
        }
        return view('admin.student.detail')->with(['student' => @$student,'examBoardName'=>@$examBoardName]);
    }

    /**
     * -------------------------------------------------
     * | Edit student page                             |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function edit(Student $Student,$uuid)
    {
        $methodType = __('formname.student.student_update');
        $student = $this->student::whereUuid($uuid)->firstOrFail();
        $parentUser = ParentUser::orderBy('id')->get()->pluck('full_name_with_email', 'id');
        $examType = $this->boardList();
        $examStyle = $this->mergeSelectOption(config('constant.exam_style'),__('formname.exam_style'));
        $schoolList = Schools::pluck('school_name','id');
        $statusList = $this->properStatusList();
        $examBoardList = ExamBoard::orderBy('id','asc')->get();
        return view('admin.student.edit', ['examBoardList'=>@$examBoardList,'statusList'=>@$statusList,'schoolList'=>@$schoolList,'methodType'=> @$methodType,'student'=> @$student, 'parentUser' => @$parentUser,'examType'=>@$examType,'examStyle'=>@$examStyle]);
    }

    /**
     * -------------------------------------------------
     * | Update student details                        |
     * |                                               |
     * | @param StudentRequest $request                |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function update(StudentRequest $request, $uuid)
    {
        if($request->password == null){
            $request->request->remove('password');
        }else{
            $request->password = Hash::make('password');
        }
        $student = $this->student::whereUuid($uuid)->firstOrFail();
        $student->fill($request->all())->save();
        if($request->exam_board_id){
            $data = [];
            foreach($request->exam_board_id as $key => $examBoardId){
                $data[$key]['exam_board_id'] = (int)$examBoardId;
                $data[$key]['student_id'] = (int)$student->id;
            }
            StudentExamBoard::insert($data);
        }
        return redirect()->route('student.index')->with('message', __('admin_messages.student.student_updated_msg'));
    }

    /**
     * -------------------------------------------------
     * | Update student status details                 |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request, $id = null)
    {
        $student = $this->student::where('uuid', $id)->first();
        if($student->parents->status == config('constant.status_inactive_value')){
            return response()->json(['msg' => __('formname.student.parent_status'), 'icon' => __('admin_messages.icon_info')]);
        }
        $status = $student->active == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $student->update(['active'=>@$status]);
        return response()->json(['msg' => __('admin_messages.action_msg',['action'=>($status == config('constant.status_active_value'))?__('admin_messages.activated'):__('admin_messages.inactivated'),'type' => __('admin_messages.student.student')]), 'icon' => __('admin_messages.icon_success')]);
    }

    /**
     * -------------------------------------------------
     * | Multiple Action                               |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function bulkAction(Request $request)
    {
        $this->dbStart();
        try  {
            $studentIdArray = $request->input('ids');
            $student = $this->student::whereIn('uuid', $studentIdArray);
            foreach($student->get() as $data){
                if($data->parents->status == 0){
                    return response()->json(['msg' => __('formname.student.parent_status_multiple'), 'icon' => __('admin_messages.icon_info')]);
                }
            }
            if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
                $student->update(['active' => ($request->action == config('constant.inactive'))?config('constant.status_inactive_value'):config('constant.status_active_value')]);
                $msg = ($request->action == config('constant.inactive'))?__('admin_messages.student.status_inactivated'):__('admin_messages.student.status_activated');
            } else {
                $student->delete();
                $msg = __('admin_messages.student.deleted_msg');
            }
            $this->dbCommit();
            return response()->json(['msg' => $msg, 'icon' => __('admin_messages.icon_success')]);
        } catch (Exception $e)  {
            $this->dbEnd();
            return response()->json(['msg' =>  'Something went wrong! Please try after some time.', 'icon' => __('admin_messages.icon_error')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Delete student details                        |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        // check if request of id is not null
        if (isset($request->id)) {
            $student = $this->student::whereUuid($request->id)->firstOrFail();
            $student->delete();
            return response()->json(['msg' => Lang::get('message.delete_student'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => Lang::get('message.deleted'), 'icon' => __('admin_messages.icon_info')]);
        }
    }
}
