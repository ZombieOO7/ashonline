<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PermissionFormRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Lang;
use Redirect;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class PermissionController extends BaseController
{
    public $viewConstant = 'admin.permission.';
    /**
     * -----------------------------------------------------
     * | Permission list                                   |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function index()
    {
        return view($this->viewConstant.'index');
    }

    /**
     * -----------------------------------------------------
     * | Permission datatables data                        |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function getdata(Request $request)
    {
        $permissions = Permission::groupBy('id');
        return Datatables::of($permissions)
            ->addColumn('name', function ($permission) {
                return ucwords(str_replace('_', ' ', $permission->name));
            })
            ->addColumn('action', function ($permission) {
                return $this->getPartials($this->viewConstant .'_add_action',['permission' => $permission]);
            })
            ->addColumn('checkbox', function ($permission) {
                return $this->getPartials($this->viewConstant .'_add_checkbox',['permission' => $permission]);
            })
            ->rawColumns(['checkbox', 'action', 'status'])
            ->make(true);
    }

    /**
     * -----------------------------------------------------
     * | Create/Update Permission form                     |
     * |                                                   |
     * | @param $id                                        |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function create($id = null)
    {
        // check if id exist 
        if (isset($id)) {
            $permission = Permission::find($id);
        }
        return view($this->viewConstant.'create_permission',['permission'=>@$permission]);
    }

    /**
     * -----------------------------------------------------
     * | Store/Edit Permission form                        |
     * |                                                   |
     * | @param PermissionFormRequest $request             |
     * | @return Redirect                                  |
     * -----------------------------------------------------
     */
    public function store(PermissionFormRequest $request)
    {
        // check if request has id or not empty
        $msg = isset($request->id) ? __('formname.permission_update_success') : __('formname.permission_create_success');
        Permission::updateOrCreate(['id'=>$request->id],['guard_name' => 'admin', 'name' => $request->name]);
        $superadmins = Admin::role('superadmin')->get();
        foreach ($superadmins as $admin) {
            $admin->givePermissionTo($request->name);
        }
        return Redirect::route('permission_index')->with('message', $msg);
    }

    /**
     * -----------------------------------------------------
     * | Delete Permission record                          |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function destroyPermission(Request $request)
    {
        // check if request has id
        if (isset($request->id)) {
            $permission = Permission::find($request->id);
            $permission->delete();
            return response()->json(['msg' => Lang::get('formname.permission_delete'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => Lang::get('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * -----------------------------------------------------
     * | Multiple Delete Permission record                 |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function multideletePermission(Request $request)
    {
        $permission_id_array = $request->input('ids');
        $permissions = Permission::whereIn('id', $permission_id_array)->delete();
        return response()->json(['msg' => __('formname.permission_delete'), 'icon' => __('admin_messages.icon_success')]);
    }
}
