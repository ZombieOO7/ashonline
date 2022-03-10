<?php

use Illuminate\Database\Seeder;

class ExamTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('exam_types')->delete();
        
        \DB::table('exam_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => NULL,
                'paper_category_id' => 3,
                'title' => 'test',
                'slug' => 'test',
                'status' => 1,
                'project_type' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => '4017e7bc-0245-4596-8f5f-039ecdf8a06f',
                'paper_category_id' => 4,
                'title' => 'test11',
                'slug' => NULL,
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-12-14 06:01:06',
                'updated_at' => '2020-12-14 06:01:44',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => '53fe16d7-7f00-40d4-ade2-4293d73a24c6',
                'paper_category_id' => 5,
                'title' => 'test09',
                'slug' => NULL,
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-12-14 06:02:27',
                'updated_at' => '2020-12-14 06:02:27',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}