<?php

use Illuminate\Database\Seeder;

class WebSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('web_settings')->delete();
        
        \DB::table('web_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'logo' => '1576576058_pexels.jpeg',
                'favicon' => '1576576058_Poké_Ball_icon.svg',
                'google_url' => NULL,
                'facebook_url' => NULL,
                'twitter_url' => NULL,
                'youtube_url' => NULL,
                'meta_keywords' => NULL,
                'meta_description' => NULL,
                'amount_1' => '20',
                'amount_2' => '70',
                'discount_1' => '10',
                'discount_2' => '20',
                'code' => 'ASDFG',
                'rating_mail' => '1',
                'code_status' => 1,
                'notification_content' => NULL,
                'project_type' => 0,
                'notification_interval' => NULL,
                'send_email' => 1,
                'mode' => 1,
                'live_key' => NULL,
                'live_secret_key' => NULL,
                'test_key' => NULL,
                'test_secret_key' => NULL,
                'smtp_host' => NULL,
                'smtp_username' => NULL,
                'smtp_password' => NULL,
                'smtp_port' => NULL,
                'smtp_driver' => NULL,
                'smtp_encryption' => NULL,
                'mail_from' => NULL,
                'interval_days' => NULL,
                'created_at' => '2019-12-17 09:47:38',
                'updated_at' => '2020-12-01 06:19:55',
            ),
        ));
        
        
    }
}