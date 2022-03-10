<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\MockTestHelper;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\MockTestFormRequest;
use App\Imports\ImportFile;
use App\Models\Question;
use App\Models\QuestionList;
use App\Models\QuestionMedia;
use App\Models\Subject;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Excel;

class MockTestController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.mock-test.';
    public $route = 'mock-test.';

    public function __construct(MockTestHelper $helper, Question $question)
    {
        $this->question = $question;
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');

    }

    /**
     * -------------------------------------------------
     * | Display Mock Test list                        |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        try {
            // $this->helper->disableMockExam();
            $statusList = $this->properStatusList();
            return view($this->viewConstant . 'index', ['statusList' => @$statusList]);
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * -------------------------------------------------
     * | Get Mock Test datatable                       |
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
            $mockTest = $this->helper->list();
            $itemQuery = $mockTest->where(function ($query) use ($request) {
                // check if request has id or not
                if ($request->status != null) {
                    $query->activeSearch($request->status);
                }
            });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $mockTestList = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return DataTables::of($mockTestList)
                ->addColumn('action', function ($mockTest) {
                    return $this->getPartials($this->viewConstant . '_add_action', ['mockTest' => @$mockTest]);
                })
                ->editColumn('status', function ($mockTest) {
                    return $this->getPartials($this->viewConstant . '_add_status', ['mockTest' => @$mockTest]);
                })
                ->editColumn('exam_board_id', function ($mockTest) {
                    return @$mockTest->examBoard->title;
                })
                ->editColumn('grade_id', function ($mockTest) {
                    return @$mockTest->grade->title;
                })
                ->editColumn('created_at', function ($mockTest) {
                    return @$mockTest->proper_created_at;
                })
                ->editColumn('price', function ($mockTest) {
                    return @config('constant.currency_symbol') . $mockTest->price;
                })
                ->editColumn('start_date', function ($mockTest) {
                    return @$mockTest->proper_start_date;
                })
                ->editColumn('end_date', function ($mockTest) {
                    return @$mockTest->proper_end_date;
                })
                ->editColumn('title', function ($mockTest) {
                    return $this->getPartials($this->viewConstant . '_add_message', ['mockTest' => $mockTest, 'title' => __('formname.mock-test.title')]);
                })
                ->addColumn('checkbox', function ($mockTest) {
                    return $this->getPartials($this->viewConstant . '_add_checkbox', ['mockTest' => @$mockTest]);
                })
                ->with(["draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total, "recordsFiltered" => $count_filter])
                ->rawColumns(['end_date', 'start_date', 'title', 'created_at', 'checkbox', 'action', 'status'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Mock Test page                         |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($uuid = null)
    {
        try {
            $routeName = Route::currentRouteName();
            $title = __('formname.mock-test.create');
            // check if uuid not null
            if (isset($uuid)) {
                $mockTest = $this->helper->detail($uuid);
                $subjectIds = $mockTest->MockTestSubjectQuestion->pluck('subject_id');
                $parentIds = $mockTest->parentMockTest->pluck('parent_id');
                $title = __('formname.mock-test.update');
            }
            if ($routeName == 'mock-test.copy') {
                $title = __('formname.mock-test.copy');
                $route = 'mock-test.copy-exam';
            }
            $statusList = $this->properStatusList();
            $subjectList = $this->subjectList();
            $gradeList = $this->gradeList();
            $boardList = $this->boardList();
            $schoolList = $this->schoolList();
            $parentList = $this->allParentList();
            $questionTypes = $this->questionSubType();
            $intervalList = $this->intervalList();
            $topics = $this->topicList();
            return view($this->viewConstant . 'create', ['topics'=>@$topics,'intervalList' => @$intervalList, 'mockTest' => @$mockTest, 'title' => @$title, 'statusList' => @$statusList, 'subjectList' => $subjectList, 'gradeList' => $gradeList, 'boardList' => $boardList, 'schoolList' => @$schoolList, 'subjectIds' => @$subjectIds, 'route' => @$route, 'parentList' => @$parentList, 'parentIds' => @$parentIds, 'questionTypes' => @$questionTypes]);
        } catch (Exception $e) {
            abort(404);
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    /**
     * -------------------------------------------------
     * | Store Mock Test details                       |
     * |                                               |
     * | @param MockTestFormRequest $request           |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(MockTestFormRequest $request, $uuid = null)
    {
        // dd($request->all());
        $this->helper->dbStart();
        try {
            $data = $this->helper->store($request, $uuid);
            $errors = @$data['errors'];
            $mockTest = @$data['mockTest'];
            $routeName = Route::currentRouteName();
            // if(@$errors != null){
            //     return redirect()->back()->withInput()->withErrors($errors);
            // }
            $this->helper->dbEnd();
            // check if route is use to copy mock exam
            if ($routeName == 'mock-test.copy-exam') {
                $msg = __('formname.action_msg', ['action' => __('formname.copied'), 'type' => __('formname.mock_test_id')]);
            } elseif ($request->has('id') && !empty($request->id)) {
                $msg = __('formname.action_msg', ['action' => __('formname.updated'), 'type' => __('formname.mock_test_id')]);
            } else {
                $msg = __('formname.action_msg', ['action' => __('formname.created'), 'type' => __('formname.mock_test_id')]);
            }
            // return redirect()->route($this->route . 'index')->with('message', $msg);
            return redirect()->route($this->route . 'detail',['uuid'=>@$mockTest->uuid])->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return Redirect::back()->with('error', $e->getMessage());
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Delete Mock Test details                      |
     * |                                               |
     * | @param Request $request |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        $this->helper->dbStart();
        try {
            // check if request has id or not
            if (isset($request->id)) {
                $this->helper->delete($request->id);
                $this->helper->dbEnd();
                $msg = __('formname.action_msg', ['action' => __('formname.deleted'), 'type' => __('formname.mock_test_id')]);
                return response()->json(['msg' => $msg, 'icon' => 'success']);
            }
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Delete multiple Mock Test                     |
     * | @param Request $request |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multidelete(Request $request)
    {
        $this->helper->dbStart();
        try {
            $this->helper->dbEnd();
            $this->helper->multiDelete($request);
            // check if request action is active, inactive or delete
            if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
                $action = ($request->action == config('constant.active')) ? __('formname.activated') : __('formname.inactivated');
                $msg = __('formname.action_msg', ['action' => $action, 'type' => __('formname.mock_test_id')]);
                return response()->json(['msg' => $msg, 'icon' => 'success']);
            }
            $msg = __('formname.action_msg', ['action' => __('formname.deleted'), 'type' => __('formname.mock_test_id')]);
            return response()->json(['msg' => @$msg, 'icon' => 'success']);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Update Mock Test status                       |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        $this->helper->dbStart();
        try {
            // check if request has id or not
            if (isset($request->id)) {
                $msg = $this->helper->statusUpdate($request->id);
                $this->helper->dbEnd();
                return response()->json(['msg' => @$msg, 'icon' => 'success']);
            }
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Mock Test subject detail                      |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function subjectDetail(Request $request)
    {
        try {
            // check if request has subject ids
            if ($request->subject_ids) {
                $subjects = $this->helper->subjectDetail($request);
                return view($this->viewConstant . '_time', ['subjects' => @$subjects[0], 'mockTestDetail' => @$subjects[1]]);
            } else {
                return;
            }
        } catch (Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Mock Test question list                       |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function questionList(Request $request)
    {
        $questions = $this->question::select('id','question_type','type','question_title','topic_id','active')
            ->whereSubjectId($request->subject_id)
            ->where(function ($q) use ($request) {
                if ($request->question_type != null) {
                    $q->where('question_type', $request->question_type);
                }
            })
            ->whereActive(1)
            ->get();
        return DataTables::of($questions)
            ->editColumn('type', function ($mockTest) {
                return @config('constant.question_type')[$mockTest->type];
            })
            ->editColumn('question_type', function ($mockTest) {
                return @config('constant.questionSubType')[$mockTest->question_type];
            })
            ->editColumn('question_title', function ($questionData) {
                return $this->getPartials('admin.question_management._add_message', ['questionData' => $questionData,'title'=>__('formname.question.question_title')]);
            })
            ->editColumn('topic', function ($mockTest) {
                return @$mockTest->topic->title;
            })
            ->addColumn('checkbox', function ($mockTest) {
                return $this->getPartials($this->viewConstant . '_add_checkbox', ['mockTest' => @$mockTest]);
            })
            ->rawColumns(['question_title', 'type', 'checkbox'])
            ->make(true);
    }

    /**
     * -------------------------------------------------
     * | Mock Test detail                              |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function detail($uuid)
    {
        $mockTest = $mockTest = $this->helper->detail($uuid);
        $subjectIds = $mockTest->subjects->pluck('subject_id');
        $statusList = $this->statusList();
        $subjectList = $this->subjectList();
        $gradeList = $this->gradeList();
        $boardList = $this->boardList();
        $schoolList = $this->schoolList();
        $title = __('formname.mock-test.detail');
        return view($this->viewConstant . '_detail', ['mockTest' => @$mockTest, 'title' => @$title, 'statusList' => @$statusList,
            'subjectList' => $subjectList, 'gradeList' => $gradeList, 'boardList' => $boardList, 'schoolList' => @$schoolList,
            'subjectIds' => @$subjectIds]);
    }

    /**
     * -------------------------------------------------
     * | Mock Test image                               |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function imageGet(Request $request)
    {
        $imageGet = commonImageId($request->image_id);
        $id = $imageGet->id;
        $imageShow = $imageGet->path;
        $image = $imageGet->image_path;
        return view('admin.mock-test._image_show', ['image'=>@$image,'imageShow' => @$imageShow, 'id' => @$id]);

    }

    /**
     * -------------------------------------------------
     * | Mock Test image datatables                    |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getImage(Request $request)
    {

        try {
            $stages = $this->commonImageIdCheck();
            $imageId = $request->image_id;
            $stageList = $stages->get();
            return Datatables::of($stageList)
                ->addColumn('path', function ($list) {
                    return '<img src="' . @$list->image_path . '" alt="' . @$list->image_path . '" width="70" height="70" >';
                })->addColumn('checkbox', function ($mocktest) use ($imageId) {
                    return $this->getPartials($this->viewConstant . '_add_image_action_checkbox', ['mocktest' => @$mocktest, 'image_id' => @$imageId]);
                })
                ->rawColumns(['checkbox', 'path'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Generate Mock Test paper layout               |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function generatePaperLayout(Request $request){
        if($request->has('no_of_papers')){
            $subjectList = $this->subjectList();
        }
        if($request->has('subject_id')){
            $subjects = Subject::whereIn('id',$request->subject_id)
                        ->select('id','title','slug')
                        ->orderBy('id','asc')
                        ->get();
            $topics = $this->topicList();
        }
        $i = 0;
        if($request->stage_id != null && $request->stage_id == 2){
            $subjectList = $this->subjectList2();
        }else{
            $subjectList = $this->subjectList();
        }
        $array = [  'subjects'=>@$subjects,
                    'subjectIds' => @$request->subject_id,
                    'papers' => @$request->no_of_papers,
                    'subjectList'=>@$subjectList,
                    'paperKey'=>@$request->paper_key,
                    'topics'=>@$topics,
                    'no_of_section'=> $request->no_of_section,
                    'i' => $request->no_of_section,
                ];
        $htmlView = $this->getPartials($this->viewConstant .'_papers',$array);
        return response()->json(['status'=>'success','html'=>@$htmlView]);
    }
}
