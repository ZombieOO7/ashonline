<?php

namespace App\Console\Commands;

use App\Models\StudentTest;
use App\Models\StudentTestResults;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateTestResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:result';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update mock result';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tests = StudentTest::orderBy('id', 'desc')->get();
        foreach($tests as $test){
            $testResults = StudentTestResults::where(['student_test_id'=>$test->id,'is_reset'=>0])
                            ->orderBy('overall_result', 'desc')
                            ->select('*',DB::raw('count(student_test_results.id) as result_id, student_id'))
                            ->distinct('student_id')
                            ->groupBy('student_id','id')
                            ->get();
            $rank = 0;
            foreach($testResults as $testResult){
                $rank++;
                $testResult = StudentTestResults::find($testResult->id)->update(['rank'=>$rank]);
            }
        }
    }
}
