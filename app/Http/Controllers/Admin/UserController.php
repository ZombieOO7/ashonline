<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserExport;
use App\Helpers\UserHelper;
use App\Http\Requests\Admin\UserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Lang;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;
use Yajra\Datatables\Datatables;

class UserController extends BaseController
{
    private $userHelper;
    public $viewConstant = 'admin.user.';

    public function __construct(UserHelper $userHelper)
    {
        $this->userHelper = $userHelper;
        $this->userHelper->mode = config('constant.admin');
    }

    /**
     * -----------------------------------------------------
     * | User list                                         |
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
     * | User datatables data                              |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function getdata(Request $request)
    {
        $users = $this->userHelper->getAllUsers();
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return $this->getPartials($this->viewConstant . '_add_action', ['user' => @$user]);
            })
            ->editColumn('status', function ($user) {
                return $this->getPartials($this->viewConstant . '_add_status', ['user' => @$user]);
            })
            ->addColumn('checkbox', function ($user) {
                return $this->getPartials($this->viewConstant . '_add_checkbox', ['user' => @$user]);
            })
            ->rawColumns(['checkbox', 'action', 'status'])
            ->make(true);
    }

    /**
     * -----------------------------------------------------
     * | Create/Update User form                           |
     * |                                                   |
     * | @param $id                                        |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function create($id = null)
    {
        $data = [];
        // if id is not null
        if (isset($id)) {
            $user = $this->userHelper->findUserById($id);
        }
        return view('admin.user.create_user',['user'=>@$user]);
    }

    /**
     * -----------------------------------------------------
     * | Store/Edit User form                              |
     * |                                                   |
     * | @param UserFormRequest $request                   |
     * | @return Redirect                                  |
     * -----------------------------------------------------
     */
    public function store(UserFormRequest $request)
    {
        // if request has id
        $user = User::updateOrCreate(['id'=>@$request->id],$request->all());
        $msg = __('formname.action_msg', ['type' => __('formname.user'), 'action' => isset($request->id)?__('formname.updated'):__('formname.created')]);
        $user->syncRoles($request->role);
        return Redirect::route('user_index')->with('message', $msg);
    }

    /**
     * -----------------------------------------------------
     * | Delete User record                                |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function destroyUser(Request $request)
    {
        // if request has id
        if (isset($request->id)) {
            $user = $this->userHelper->findUserById($request->id);
            $user->delete();
            return response()->json(['msg' => __('formname.user_delete'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * -----------------------------------------------------
     * | Multiple Delete User record                       |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function multideleteUser(Request $request)
    {
        $user_id_array = $request->input('ids');
        // check if action is inactive records
        if ($request->action == config('constant.inactive')) {
            $users = $this->userHelper->updateMultipleStatus($user_id_array, 0);
            return response()->json(['msg' => __('formname.user_status'), 'icon' => __('admin_messages.icon_success')]);
        } else if ($request->action == 'active') {
            $users = $this->userHelper->updateMultipleStatus($user_id_array, 1);
            return response()->json(['msg' => __('formname.user_status'), 'icon' => __('admin_messages.icon_success')]);
        } else if ($request->action == 'delete') {
            $users = User::whereIn('id', $user_id_array)->get();
            foreach ($users as $user) {
                $user->delete();
            }
            return response()->json(['msg' => __('formname.user_delete'), 'icon' => __('admin_messages.icon_success')]);
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
        if (isset($request->id)) {
            $user = $user = $this->userHelper->findUserById($request->id);
            if ($user->status == config('constant.status_active_value')) {
                $user = $this->userHelper->updateStatusById($request->id, config('constant.status_inactive_value'));
            } else {
                $user = $this->userHelper->updateStatusById($request->id, config('constant.status_active_value'));
            }
            return response()->json(['msg' => __('formname.user_status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * -----------------------------------------------------
     * | Export Users to excel(.xlsx formate)              |
     * |                                                   |
     * -----------------------------------------------------
     */
    public function exportUsers()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }
}
