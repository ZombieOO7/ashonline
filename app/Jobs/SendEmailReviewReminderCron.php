<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendEmailForReviewReminder;


use Mail;

class SendEmailReviewReminderCron implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user,$details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$details)
    {
        $this->user = $user;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->queue(new SendEmailForReviewReminder($this->details,$this->user));
      
    }
}


