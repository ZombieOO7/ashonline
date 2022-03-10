<?php

namespace App\Helpers;

use App\Models\PromoCode;
use App\Models\WebSetting;
use Illuminate\Http\Request;

class PromoCodeHelper extends BaseHelper
{

    protected $promoCode;
    public function __construct(PromoCode $promoCode)
    {
        $this->promoCode = $promoCode;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Stage List                                     |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function promoCodeList()
    {
        return $this->promoCode::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | Exam type detail by id                             |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->promoCode::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | ExamType store                                     |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        // check if request has id or nout null
        if (isset($request->id)) {
            $stage = $this->promoCode::findOrFail($request->id);
            // check if request status is active record
            if ($request->status == config('constant.status_active_value')) {
                $ids = $this->promoCode::where('id', '<>', $stage->id)->pluck('id');
                $this->promoCode::whereIn('id', $ids)->update(['status' => config('constant.status_inactive_value')]);
            }
        } else {
            $stage = new PromoCode();
            // check if request status is active record
            if ($request->status == config('constant.status_active_value')) {
                $ids = $this->promoCode::pluck('id');
                $this->promoCode::whereIn('id', $ids)->update(['status' => config('constant.status_inactive_value')]);
            }
        }
        $stage->fill($request->all())->save();
        // Update Web Settings
        $this->promoCode::where('status', config('constant.status_active_value'))->firstOrFail();
        $WebSetting = WebSetting::first();
        $WebSetting->update(['amount_1' => $request->amount_1, 'amount_2' => $request->amount_2, 'discount_1' => $request->discount_1, 'discount_1' => $request->discount_1, 'code' => $request->code]);
        return $stage;
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
        $stage = $this->detail($uuid);
        $status = $stage->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->promoCode::where('id', $stage->id)->update(['status' => $status]);
        // check if status is active 
        if ($status == config('constant.status_active_value')) {
            $ids = $this->promoCode::where('id', '<>', $stage->id)->pluck('id');
            $this->promoCode::whereIn('id', $ids)->update(['status' => config('constant.status_inactive_value')]);
            $code = $this->promoCode::where('status', config('constant.status_active_value'))->firstOrFail();
            $WebSetting = WebSetting::first();
            $WebSetting->update(['amount_1' => $stage->amount_1, 'amount_2' => $stage->amount_2, 'discount_1' => $stage->discount_1, 'discount_1' => $stage->discount_1, 'code' => $stage->code]);
        }

        // Check if all are inactive
        $check = $this->promoCode::where('status', config('constant.status_active_value'))->count();
        if ($check == config('constant.status_inactive_value')) {
            $WebSetting = WebSetting::first();
            $WebSetting->update(['code_status' => 0]);
        }
    }

    /**
     * ------------------------------------------------------
     * | ExamType detail by uuid                            |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->promoCode::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Delete ExamType                                    |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $stage = $this->detail($uuid);
        $stage->delete();
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple Examtype                                    |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $stage = $this->promoCode::whereIn('id', $request->ids);
        // check if request action to delete records
        if ($request->action == config('constant.delete')) {
            $stage->delete();
        } else {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $stage->update(['status' => $status]);
        }
    }
}
