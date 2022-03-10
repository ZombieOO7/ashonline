<?php

use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('topics')->delete();
        
        \DB::table('topics')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => '5a277a85-4b41-43bf-b41e-06f00864d070',
                'title' => 'Addition',
                'active' => 1,
                'project_type' => 0,
                'created_at' => '2021-03-05 08:11:22',
                'updated_at' => '2021-03-05 08:11:22',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}