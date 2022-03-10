<?php

use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('grades')->delete();
        
        \DB::table('grades')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => NULL,
                'title' => '6+',
                'slug' => 'six_plus',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-05-05 06:46:05',
                'updated_at' => '2020-05-05 06:46:05',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => NULL,
                'title' => '7+',
                'slug' => 'seven_plus',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-05-05 06:46:18',
                'updated_at' => '2020-05-05 06:46:18',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => NULL,
                'title' => '8+',
                'slug' => 'eight_plus',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-05-05 06:46:31',
                'updated_at' => '2020-05-05 06:46:31',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'uuid' => NULL,
                'title' => '9+',
                'slug' => 'nine_plus',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-05-05 06:46:46',
                'updated_at' => '2020-05-05 06:46:46',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'uuid' => NULL,
                'title' => '10+',
                'slug' => 'ten_plus',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-05-05 06:47:01',
                'updated_at' => '2020-05-05 06:47:01',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'uuid' => NULL,
                'title' => '11+',
                'slug' => 'eleven_plus',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-05-05 06:47:17',
                'updated_at' => '2020-05-05 06:47:17',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}