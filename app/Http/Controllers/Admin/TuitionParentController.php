<?php

namespace App\Http\Controllers\Admin;

use App\Models\TuitionParent;
use App\Models\ParentUser;
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportTuitionParentFile;

class TuitionParentController extends BaseController
{
    /**
     * ---------------------------------------
     * | Display list of all tuition parents |
     * |                                     |   
     * | @return View                        |   
     * ---------------------------------------
     */
    public function index()
    {
        $statusList = $this->statusList();
        return view('admin.tuition_parents.index',['statusList' => @$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Get Parent datatable                          |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $parents = TuitionParent::orderBy('created_at','DESC')->get();
            return Datatables::of($parents)
                ->editColumn('created_at', function ($stage) {
                    return $stage->proper_created_at;
                })
                ->rawColumns(['created_at'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Import File View                              |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function import()
    {
        return view('admin.tuition_parents.import');
    }

    /**
     * -------------------------------------------------
     * | Insert Imported records                       |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function insert(Request $request)
	{
        // if request has file
		if ($request->hasFile('import_file')) {
            Excel::import(new ImportTuitionParentFile, request()->file('import_file'));
        }
        return Redirect::route('tuition_parent_index')->with('message', __('admin_messages.import_success_msg'));
    }
    
    /**
     * -------------------------------------------------
     * | Sync with Parents                             |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function sync()
    {
        $tuitionParents = TuitionParent::select('email')->get();
        foreach ($tuitionParents as $value) {
            $parentUser = ParentUser::whereEmail($value->email)->where('is_tuition_parent',0)->first();
            // if parentuser data found
            if ($parentUser) {
                $parentUser->update(['is_tuition_parent' => 1]);
            }
        }
        return Redirect::route('tuition_parent_index')->with('message', __('admin_messages.sync_success_msg'));
    }
}
