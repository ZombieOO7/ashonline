<?php

namespace App\Console\Commands;

use App\Helpers\BaseHelper;
use App\Models\StudentTestPaper;
use Illuminate\Console\Command;

class MockExamResultRank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update previos month attempetd student mock paper rank on 1st date of current month';

    protected $helper; 

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BaseHelper $helper)
    {
        $this->helper = $helper;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get previos month start and end date
        $startDate = date('Y-m-d', strtotime('first day of last month')).' 00:00:00';
        $endDate =  date('Y-m-d', strtotime('last day of last month')).' 23:59:59';
        // get previous month student attempted mock exan papers
        $studentTestPapers = StudentTestPaper::where(['is_completed'=>'1',['is_reset'=>'0','status'=>1]])
                            ->whereHas('studentResult',function($query) use($startDate,$endDate){
                                $query->whereBetween('created_at',[$startDate,$endDate]);
                            })
                            ->get();
        foreach($studentTestPapers as $studentTestPaper){
            $this->helper->updateResultRank($studentTestPaper);
        }
    }
}
