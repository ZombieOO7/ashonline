<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MockTestHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class MockTestPaperController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.mock-paper.';
    public $route = 'mock-paper.';

    public function __construct(MockTestHelper $helper, Question $question)
    {
        $this->question = $question;
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
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
        $mockTest = $this->helper->detail($uuid);
        return view($this->viewConstant.'create',['title'=>'Add Paper','mockTestId'=>@$mockTest->id,'paper'=>null,'mockTest'=>@$mockTest]);
    }

    /**
     * -------------------------------------------------
     * | Store Mock Test details                       |
     * |                                               |
     * | @param MockTestFormRequest $request           |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $mockTest = $this->helper->detailById($request->mock_test_id);
            $this->helper->storePaper($request, $uuid);
            $this->helper->dbEnd();
            if ($request->has('id') && !empty($request->id)) {
                $msg = __('formname.action_msg', ['action' => __('formname.updated'), 'type' => 'Mock Exam Paper']);
            } else {
                $msg = __('formname.action_msg', ['action' => __('formname.created'), 'type' => 'Mock Exam Paper']);
            }
            return redirect()->route('mock-test.detail',['uuid'=>@$mockTest->uuid])->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return Redirect::back()->with('error', $e->getMessage());
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
    public function edit($uuid = null)
    {
        $paper = $this->helper->paperDetail($uuid);
        $mockTest = $paper->mockTest;
        $subjectList = $this->subjectList();
        return view($this->viewConstant.'create',['title'=>'Edit Paper','mockTestId'=>@$paper->mock_test_id,'paper'=>@$paper,'subjectList'=>@$subjectList,'mockTest'=>@$mockTest]);
    }

    /**
     * -------------------------------------------------
     * | Create Mock Test page                         |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function delete(Request $request, $uuid = null)
    {
        $this->dbStart();
        try{
            $paper = $this->helper->paperDetail($request->id);
            if($paper){
                $paper->delete();
                $this->helper->dbEnd();
            }
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('formname.deleted'),'type' => 'Paper']), 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            $this->dbEnd();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }
    /**
     * -----------------------------------------------------
     * | Download AnswerSheet                              |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function downloadAnswerSheet($uuid=null){
        try{
            $paper = $this->helper->paperDetail($uuid);
            if($paper != null && $paper->answer_sheet_path != null){
                ob_end_clean();
                return response()->download($paper->answer_sheet_path2);
            }
            throw new \ErrorException(__('formname.file_not_found'));
            // return Redirect::back()->with('error', __('formname.file_not_found'));
        }catch(Exception $e){
            return Redirect::back()->with('error', $e->getMessage());
        }
    }
}
