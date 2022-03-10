<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schools;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SchoolsRequest;
use Yajra\Datatables\Datatables;

class SchoolsController extends BaseController
{
    protected $Schools;

    public function __construct(Schools $Schools)
    {
        $this->Schools = $Schools;
    }
    /**
     * Display a listing of the school.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.schools.index');
    }

    /**
     * Show Data using Datatables
     */

    public function getData(Schools $Schools, Request $request)
    {
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        $itemQuery = $this->Schools::orderBy('created_at', 'desc')->where(function ($query) use ($request) {
            if ($request->status) {
                $query->activeSearch($request->status);
            }
        });
        $count_total = $itemQuery->count();
        $itemQuery = $itemQuery->skip($start)->take($limit);
        $Schools = $itemQuery->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return Datatables::of($Schools)
            ->addColumn('action', function ($Schools) {
                return \View::make('admin.schools.action', ['Schools' => @$Schools, 'colType' => config('constant.col_action')])->render();
            })
            ->editColumn('active', function ($Schools) {
                return \View::make('admin.schools.add_status', ['Schools' => @$Schools])->render();
            })
            ->editColumn('categories', function ($Schools) {
                return @$Schools->examBoard->title;
            })
            ->editColumn('created_at', function ($Schools) {
                return @$Schools->proper_created_at;
            })
            ->addColumn('checkbox', function ($Schools) use ($request) {
                return \View::make('admin.schools.action', ['SchoolsTable' => @$Schools, 'colType' => config('constant.col_checkbox')])->render();
            })
            ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
            ->rawColumns(['categories','action', 'created_at', 'checkbox', 'active'])
            ->skipPaging()
            ->make(true);
    }
    /**
     * Show the form for creating a new school.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $methodType = trans('users.new_school');
        $activeStatus = isset($users) ? $users->active : '';
        $schools = '';
        $boardList = $this->boardList();
        return view('admin.schools.edit', ['boardList'=> @$boardList,'methodType' => @$methodType, 'schools' => @$schools, 'activeStatus' => @$activeStatus]);
    }

    /**
     * Store a newly created school in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolsRequest $request)
    {
        $request['is_multiple'] = $request->is_multiple ?? 0;
        $this->Schools->create($request->all());
        return redirect()->route('schools.index')->with('message', __('message.schools'));
    }

    /**
     * Display the specified school.
     *
     * @param  \App\Schools  $Schools
     * @return \Illuminate\Http\Response
     */
    public function show(Schools $Schools, $uuid)
    {
        $methodType = trans('users.show');
        $Schools = $this->Schools::whereUuid($uuid)->firstOrFail();
        return view('admin.schools.detail')->with(['methodType' => @$methodType, 'Schools' => @$Schools]);
    }

    /**
     * Show the form for editing the specified school.
     *
     * @param  \App\Schools  $Schools
     * @return \Illuminate\Http\Response
     */
    public function edit(Schools $Schools, $uuid)
    {
        $methodType = trans('users.edit_school');
        $schools = $this->Schools::whereUuid($uuid)->firstOrFail();
        $boardList = $this->boardList();
        return view('admin.schools.edit', ['methodType' => @$methodType, 'schools' => @$schools, 'boardList'=> @$boardList]);
    }

    /**
     * Update the specified school in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schools  $Schools
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolsRequest $request, Schools $Schools)
    {
        $request['is_multiple'] = $request->is_multiple ?? 0;
        $Schools = $this->Schools::whereUuid($request->uuid)->firstOrFail();
        $Schools->fill($request->all())->save();
        return redirect()->route('schools.index')->with('message', __('message.school_update'));
    }

    /**
     * Update the specified school status.
     *
     * @param  \App\Schools  $Schools
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $Schools = $this->Schools->where('uuid', $request->id)->first();
        $status = $Schools->active == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $Schools->fill(['active' => $status]);
        $Schools->save();
        $action = ($status == config('constant.status_active_value'))?__('formname.activated'):__('formname.inactivated');
        $msg = __('formname.action_msg', ['action' => $action, 'type' => __('formname.mock-test.school_id')]);
        return response()->json(['msg' => $msg, 'icon' => __('admin_messages.icon_success')]);
    }

    /**
     * Remove the specified school from storage.
     *
     * @param  \App\Schools  $Schools
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // check if request has id
        if (isset($request->id)) {
            $Schools = $this->Schools::whereUuid($request->id)->firstOrFail();
            $Schools->delete();
            return response()->json(['msg' => __('message.delete_Schools'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('message.deleted'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * Update status or remove the specified school.
     *
     * @param  \App\Schools  $Schools
     * @return \Illuminate\Http\Response
     */
    public function bulkAction(Request $request)
    {
        $SchoolsIdArray = $request->input('ids');
        $Schools = $this->Schools::whereIn('id', $SchoolsIdArray);
        // check if request action is active, inactive or delete
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $Schools->update(['active' => $status]);
            $action = ($request->action == config('constant.active')) ? __('formname.activated') : __('formname.inactivated');
            $msg = __('formname.action_msg', ['action' => $action, 'type' => __('formname.mock-test.school_id')]);
            return response()->json(['msg' => $msg, 'icon' => __('admin_messages.icon_success')]);
        }
        $Schools->delete();
        return response()->json(['msg' => __('message.delete_Schools'), 'icon' => __('admin_messages.icon_success')]);
    }
}
