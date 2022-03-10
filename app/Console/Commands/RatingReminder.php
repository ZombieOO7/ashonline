<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendEmailReviewReminderCron;
use App\Models\BillingAddress;
use Carbon\Carbon;
use App\Models\WebSetting;
use App\Models\Order;


class RatingReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratingreminder:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to user rating and review feedback';

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
        $users = BillingAddress::whereHas('order',function($query) {
            $query->whereDoesntHave('review');
            $query->where('is_remind',0);
        })->get();


        foreach($users as $user) 
        {
            $date = Carbon::parse($user->order->created_at);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);
            $setting = WebSetting::firstOrFail();
            $days = @$setting->rating_mail ? $setting->rating_mail : 1;
            if( $diff >= $days ) {
                
                $this->sendReviewReminderEmailNotificationCron($user,$user->order);   

                // Update review remind status
                Order::whereId($user->order->id)->update(['is_remind' => 1]);
            }
        }
    }

    public function sendReviewReminderEmailNotificationCron($user,$order) 
    {
        $item = @$order->items;
        $billingAddress = BillingAddress::whereOrderId($order->id)->first();
        $details = [ 'body' => 'Please provide us feedback','subject' => 'Review Feedback Reminder','thanks' => 'Thanks & Regards','actionURL' => route('feedback',['uuid' => $order->uuid]),'order' => $order,'item' => @$item[0],'billingAddress' => @$billingAddress];
        return dispatch(new SendEmailReviewReminderCron($user,$details))->delay(now()->addMinutes(1));
    }
}
