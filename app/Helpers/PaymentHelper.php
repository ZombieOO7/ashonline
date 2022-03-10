<?php

namespace App\Helpers;

use App\Models\Payment;

class PaymentHelper extends BaseHelper
{
    protected $payment;
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        parent::__construct();
    }

    /**
     * ------------------------------------------------------
     * | Get Payment List                                   |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function paymentList()
    {
        return $this->payment::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | Payment detail by id                               |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->payment::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | payment detail by uuid                             |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->payment::where('uuid', $uuid)->first();
    }

}
