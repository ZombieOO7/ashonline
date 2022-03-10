<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'first_name' => 'Carol',
                'last_name' => 'Crowley',
                'email' => 'webclues.user@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$3jjysjpvQmlbIDmiGBHQ9elGGDaLKj6RHlP25xF.lkMvc63ubDo4a',
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => '2019-12-17 09:34:58',
                'updated_at' => '2019-12-17 09:34:58',
            ),
        ));
        
        
    }
}