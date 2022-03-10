<?php

namespace App\Exports;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\User;

class QuestionExport implements FromView
{
    protected $questions;
    function __construct($questions) {
        $this->questions = $questions;
    }
    public function view(): View
    {
        return view('admin.exports.question', [
            'questions' => $this->questions
        ]);
    }
}
