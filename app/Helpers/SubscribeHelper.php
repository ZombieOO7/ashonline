<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscribeHelper extends BaseHelper
{
    protected $subscriber;
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
        parent::__construct();
    }


}
