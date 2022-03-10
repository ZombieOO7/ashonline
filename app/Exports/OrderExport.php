<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    protected $orders;
    function __construct($orders) {
        $this->orders = $orders;
    }
    /**
     * ------------------------------------------------------
     * | Get Sold Paper Order Report                        |
     * | @param Request $request                            |
     * | @return File                                       |
     * |-----------------------------------------------------
    */
    public function view(): View
    {
        $items = $this->orders;
        return view('admin.exports.order', ['items' => @$items]);
    }
}
