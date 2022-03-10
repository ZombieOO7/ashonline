<?php

namespace App\Helpers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicHelper extends BaseHelper
{
    protected $topic;
    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Topic List                                     |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function list()
    {
        return $this->topic::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | Topic detail by id                                 |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->topic::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | Topic store                                        |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        $topic = Topic::updateOrCreate(['id'=>@$request->id],$request->all());
        return $topic;
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
        $topic = $this->detail($uuid);
        $status = $topic->active == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->topic::where('id', $topic->id)->update(['active' => $status]);
        return $status;
    }

    /**
     * ------------------------------------------------------
     * | Topic detail by uuid                               |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->topic::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Delete Topic                                       |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $topic = $this->detail($uuid);
        $topic->delete();
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple Topic                                       |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $topic = $this->topic::whereIn('id', $request->ids);
        // check if request action is delete
        if ($request->action == config('constant.delete')) {
            $topic->delete();
            return;
        }
        $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $topic->update(['active' => $status]);
    }

}
