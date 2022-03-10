<?php

namespace App\Helpers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionHelper extends BaseHelper
{
    protected $subscription;
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Subscription List                              |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function list()
    {
        return $this->subscription::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | Subscription detail by id                          |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->subscription::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | Subscription store                                 |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        $subscription = Subscription::updateOrCreate(['id'=>@$request->id],$request->all());
        return $subscription;
    }

    /**
     * ------------------------------------------------------
     * | Update status                                      |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function statusUpdate($uuid)
    {
        $subscription = $this->detail($uuid);
        $status = $subscription->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->subscription::where('id', $subscription->id)->update(['status' => $status]);
        return $status;
    }

    /**
     * ------------------------------------------------------
     * | Subscription detail by uuid                        |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->subscription::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Delete Subscription                                |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $subscription = $this->detail($uuid);
        $subscription->delete();
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple Subscription                                |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $subscription = $this->subscription::whereIn('id', $request->ids);
        // check if request action is delete
        if ($request->action == config('constant.delete')) {
            $subscription->delete();
            return;
        }
        $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $subscription->update(['status' => $status]);
    }

}
