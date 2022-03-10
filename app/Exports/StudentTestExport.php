<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\User;

class StudentTestExport implements FromView
{
    protected $reportData,$reportType;
    function __construct($reportData,$reportType) {
        $this->reportData = $reportData;
        $this->reportType= $reportType;
    }
    
    /**
     * ------------------------------------------------------
     * | Get Attempt Test Report                            |
     * | @param Request $request                            |
     * | @return File                                       |
     * |-----------------------------------------------------
    */
    public function view(): View
    {
        return view('admin.exports.studentTest', ['reportData'=>@$this->reportData,'reportType'=>@$this->reportType]);
    }
}
