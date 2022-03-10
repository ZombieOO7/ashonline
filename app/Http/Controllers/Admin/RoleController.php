<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RoleFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Redirect;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class RoleController extends BaseController
{
    public $viewConstant = 'admin.role.';

    /**
     * -----------------------------------------------------
     * | Role list                                         |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function index(Request $request)
    {
        return view($this->viewConstant . 'index');
    }

    /**
     * -----------------------------------------------------
     * | Role datatables data                              |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function getdata(Request $request)
    {
        $roles = Role::groupBy('id');
        return Datatables::of($roles)
            ->addColumn('role_name', function ($role) {
                return $role->name;
            })
            ->addColumn('action', function ($role) {
                return $this->getPartials($this->viewConstant . '_add_action', ['role' => $role]);
            })
            ->filterColumn('status', function ($query, $keyword) {
                if (strtolower($keyword) == 'active') {
                    $status = '1';
                } else if (strtolower($keyword) == 'inactive') {
                    $status = '0';
                } else {
                    $status = null;
                }
                $query->where('status', '=', $status);
            })
            ->addColumn('checkbox', function ($role) {
                return $this->getPartials($this->viewConstant . '_add_checkbox', ['role' => $role]);
            })
            ->rawColumns(['checkbox', 'action', 'status'])
            ->make(true);
    }

    /**
     * -----------------------------------------------------
     * | Create/Update Role form                           |
     * |                                                   |
     * | @param $id                                        |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function create($id = null)
    {
        $data = [];
        // check if id exist
        if (isset($id)) {
            $role = Role::find($id);
        }
        $admin = Auth::user();
        $roleName = $admin->getRoleNames()->first();
        $role = Role::where('name', $roleName)->first();
        return view($this->viewConstant.'create_role',['role'=>@$role]);

    }

    /**
     * -----------------------------------------------------
     * | Store/Edit Role form                              |
     * |                                                   |
     * | @param RoleFormRequest $request                   |
     * | @return Redirect                                  |
     * -----------------------------------------------------
     */
    public function store(RoleFormRequest $request)
    {
        Role::updateOrCreate(['id'=>$request->id],['guard_name' => 'admin', 'name' => $request->name]);
        $msg = isset($request->id)? __('admin_messages.role_updated_msg'):__('admin_messages.role_created_msg');
        return Redirect::route('role_index')->with('message', $msg);
    }

    /**
     * -----------------------------------------------------
     * | Delete Role record                                |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function destroyRole(Request $request)
    {
        // check if request has id or not
        if (isset($request->id)) {
            $role = Role::find($request->id);
            $role->delete();
            return response()->json(['msg' => Lang::get('formname.role_delete'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => Lang::get('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -----------------------------------------------------
     * | Multiple Delete Role record                       |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function multideleteRole(Request $request)
    {
        $role_id_array = $request->input('ids');
        $roles = Role::whereIn('id', $role_id_array)->delete();
        return response()->json(['msg' => Lang::get('formname.role_delete'), 'icon' => __('admin_messages.icon_success')]);
    }
}
