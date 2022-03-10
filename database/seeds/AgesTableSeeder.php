<?php

use Illuminate\Database\Seeder;

class AgesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ages')->delete();
        
        \DB::table('ages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => 'de3a543b-2564-11ea-b13f-000c29f164c3',
                'title' => '7 - 8',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2019-12-23 09:16:53',
                'updated_at' => '2019-12-23 09:16:53',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => 'e715ce2f-2564-11ea-b13f-000c29f164c3',
                'title' => '8 - 9',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2019-12-23 09:16:29',
                'updated_at' => '2019-12-23 09:16:29',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => 'ec6d8b99-2564-11ea-b13f-000c29f164c3',
                'title' => '9 - 10',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2019-12-23 09:16:38',
                'updated_at' => '2019-12-23 09:16:38',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'uuid' => 'f2bb13b8-2564-11ea-b13f-000c29f164c3',
                'title' => '10 - 11',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2019-12-23 09:16:48',
                'updated_at' => '2019-12-23 09:16:48',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}