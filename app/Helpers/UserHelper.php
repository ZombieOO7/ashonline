<?php

namespace App\Helpers;

use App\Models\User;

class UserHelper extends BaseHelper
{
    protected $user;
    public function __construct(User $user)
    {
       $this->user = $user;
       parent::__construct();
    }

    /**
     * -----------------------------------------------------
     * | Find all users list                               |
     * |                                                   |
     * -----------------------------------------------------
     */
    public function getAllUsers()
    {
        return User::groupBy('id');
    }

    /**
     * -----------------------------------------------------
     * | Find user detail by id                            |
     * |                                                   |
     * | @param $id                                        |
     * -----------------------------------------------------
     */
    public function findUserById($id)
    {
        return User::find($id);
    }

    /**
     * -----------------------------------------------------
     * | Update status                                     |
     * |                                                   |
     * | @param $id,$status                                |
     * -----------------------------------------------------
     */
    public function updateStatusById($id,$status)
    {
        return User::where('id', $id)->update(['status' => $status]);
    }

    /**
     * -----------------------------------------------------
     * | Update Multiple status                            |
     * |                                                   |
     * | @param $ids,$status                               |
     * -----------------------------------------------------
     */
    public function updateMultipleStatus($ids,$status)
    {
        return User::whereIn('id', $ids)->update(['status' => $status]);
    }
}