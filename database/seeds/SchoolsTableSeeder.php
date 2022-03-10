<?php

use Illuminate\Database\Seeder;

class SchoolsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schools')->delete();
        
        \DB::table('schools')->insert(array (
            0 => 
            array (
                'id' => 144,
                'uuid' => 'cffa0c87-480b-4d2e-8c19-09fd641c7a57',
                'school_name' => 'SUTTON',
                'categories' => 2,
                'project_type' => 0,
                'is_multiple' => 1,
                'active' => 1,
                'created_at' => '2021-03-05 07:01:23',
                'updated_at' => '2021-03-05 07:04:23',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 145,
                'uuid' => '40343193-899a-4570-abcb-dce89ab6f71c',
                'school_name' => 'St Olave',
                'categories' => 4,
                'project_type' => 0,
                'is_multiple' => 1,
                'active' => 1,
                'created_at' => '2021-03-05 07:01:59',
                'updated_at' => '2021-03-05 07:01:59',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 146,
                'uuid' => '900d4b50-52ba-4ef8-9624-9aa3dc58e71b',
                'school_name' => 'SEVENOAKS',
                'categories' => 1,
                'project_type' => 0,
                'is_multiple' => 0,
                'active' => 1,
                'created_at' => '2021-03-05 07:02:40',
                'updated_at' => '2021-03-05 07:02:40',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 147,
                'uuid' => 'dce4acaa-596c-45ac-a08b-81d83c6aef4d',
                'school_name' => 'SW-HERTS',
                'categories' => 3,
                'project_type' => 0,
                'is_multiple' => 1,
                'active' => 1,
                'created_at' => '2021-03-05 07:04:02',
                'updated_at' => '2021-03-05 07:04:02',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}