<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MockTest;
use Carbon\Carbon;


class DisableMock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'disable:mock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'disable mock';

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
        $today = Carbon::now();
        $mockExam = MockTest::where('end_date','<',$today)
                    ->update(['start_date'=>null,'end_date'=>null,'status'=>0]);
        return;
    }
}
