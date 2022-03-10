<?php

use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subscriptions')->delete();
        
        \DB::table('subscriptions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => '30059855-7646-46b6-a219-3aa266033b19',
                'title' => 'Monthly',
                'description' => NULL,
                'currency' => 'GBP',
                'price' => 198.0,
                'payment_date' => '2',
                'status' => 1,
                'type' => 1,
                'created_at' => '2021-03-05 07:39:44',
                'updated_at' => '2021-03-05 07:39:44',
                'deleted_at' => NULL,
                'daily_charge' => 2.0,
            ),
        ));
        
        
    }
}