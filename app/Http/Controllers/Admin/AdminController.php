<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminFormRequest;
use App\Models\Admin;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Redirect;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class AdminController extends BaseController
{
    public $viewConstant = 'admin.admin.';
    /**
     * -----------------------------------------------------
     * | Admin users list                                  |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function index()
    {
        $statusList = $this->statusList();
        return view($this->viewConstant.'index', ['statusList'=>@$statusList]);
    }

    /**
     * -----------------------------------------------------
     * | Admin user datatables data                        |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function getdata(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $userId = $user->id;
        $roleName = $user->getRoleNames()->first();
        $admins = new Admin();
        // check if role name is superadmin or role name not null
        if ($roleName != null && $roleName != config('constant.role')[1]) {
            $admins = Admin::where('id', $userId)->orWhere('parent_id', $userId);
        }
        $adminList = $admins->where(function ($query) use ($request) {
            // check if request has status
            if ($request->status) {
                $query->active($request->status);
            }
        })->get();
        return Datatables::of($adminList)
            ->addColumn('action', function ($admin) {
                return $this->getPartials($this->viewConstant .'_add_action',['admin'=>$admin]);
            })
            ->editColumn('status', function ($admin) {
                return $this->getPartials($this->viewConstant .'_add_status',['admin'=>$admin]);
            })
            ->addColumn('checkbox', function ($admin) {
                return $this->getPartials($this->viewConstant .'_add_checkbox',['admin'=>$admin]);
            })
            ->rawColumns(['checkbox', 'action', 'status'])
            ->make(true);
    }

    /**
     * -----------------------------------------------------
     * | Create/Update Admin user form                     |
     * |                                                   |
     * | @param $id                                        |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function create($id = null)
    {
        try{
            // check is id exist
            if (isset($id)) {
                $admin = Admin::find($id);
            }
            $user = Auth::user();
            $roleName = $user->getRoleNames()->first();
            $permission = $user->permissions()->pluck('name', 'id');
            // check if role name is superadmin
            if ($roleName == config('constant.role')[1]) {
                $permission = Permission::pluck('name', 'id')->all();
            }
    
            $role = Role::where('guard_name', 'admin')
                ->where(function ($q) use ($roleName) {
                    if ($roleName != 'superadmin') {
                        $q->where('name', '!=', 'superadmin');
                    }
                })->pluck('name', 'name');
            return view($this->viewConstant.'create_admin', ['admin' => @$admin, 'role' => @$role, 'permission' => @$permission]);
        }catch(Exception $e){
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * -----------------------------------------------------
     * | Store/Edit Admin form                             |
     * |                                                   |
     * | @param AdminFormRequest $request                  |
     * | @return Redirect                                  |
     * -----------------------------------------------------
     */
    public function store(AdminFormRequest $request)
    {
        $this->dbStart();
        try{
            $admin = Admin::updateOrCreate(['id'=>$request->id],$request->all());
            $msg = isset($request->id)? __('formname.admin_upadate_success'):__('formname.admin_create_success');
            $admin->fill($request->all())->save();
            $admin->syncRoles($request->role);
            $routeName = Route::currentRouteName();
            // check if route name is profile_update
            if ($routeName != 'profile_update') {
                $admin->revokePermissionTo(Permission::all());
                $admin->givePermissionTo($request->permission);
            }
            $this->dbCommit();
            // check if route name is profile_update
            if ($routeName == 'profile_update') {
                return redirect()->route('profile')->with('message', trans('formname.profile_updated'));
            }
            return Redirect::route('admin_index')->with('message', @$msg);
        }catch(Exception $e){
            $this->dbEnd();
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * -----------------------------------------------------
     * | Delete Admin record                               |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function destroyAdmin(Request $request)
    {
        $this->dbStart();
        try{
            // check if request has id 
            if (isset($request->id)) {
                $admin = Admin::find($request->id);
                $admin->delete();
                $this->dbCommit();
                return response()->json(['msg' => __('formname.admin_delete'), 'icon' => __('admin_messages.icon_success')]);
            }
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }catch(Exception $e){
            $this->dbEnd();
            return response()->json(['msg' =>$e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -----------------------------------------------------
     * | Multiple Delete Admin user record                 |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function multideleteAdmin(Request $request)
    {
        $this->dbStart();
        try{
            $admin = Admin::whereIn('id', $request->ids);
            // check action is delete, active or inactive
            if ($request->action == config('constant.delete')) {
                $admin->delete();
                $this->dbCommit();
                return response()->json(['msg' => __('formname.admin_delete'), 'icon' => __('admin_messages.icon_success')]);
            }
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $admin->update(['status' => $status]);
            $this->dbCommit();
            return response()->json(['msg' => __('formname.admin_status'), 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            $this->dbEnd();
            return response()->json(['msg' =>$e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -----------------------------------------------------
     * | Update status                                     |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        $this->dbStart();
        try{
            if (isset($request->id)) {
                $user = Admin::find($request->id);
                $status = $user->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
                $user = Admin::where('id', $request->id)->update(['status' => $status]);
                $this->dbCommit();
                return response()->json(['msg' => __('formname.admin_status'), 'icon' => __('admin_messages.icon_success')]);
            } else {
                return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
            }
        }catch(Exception $e){
            $this->dbEnd();
            return response()->json(['msg' =>$e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -----------------------------------------------------
     * | Display Profile                                      |
     * |                                                      |
     * | @return View                                         |
     * -----------------------------------------------------
     */
    public function profile()
    {
        try{
            $id = Auth::id();
            $user = Admin::find($id);
            $permission = Permission::pluck('name', 'id')->all();
            $role = Role::where('guard_name', 'admin')
                ->pluck('name', 'name');
            $permission = $permission;
            $admin = $user;
            return view('admin.admin.profile', ['role' => @$role, 'permission' => @$permission, 'admin' => @$admin]);
        }catch(Exception $e){
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }
}
