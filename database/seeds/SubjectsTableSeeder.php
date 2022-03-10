<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subjects')->delete();
        
        \DB::table('subjects')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => 'ff8d8c9e-4e0d-4251-80ea-6d0a334aa1a8',
                'paper_category_id' => NULL,
                'title' => 'Maths',
                'slug' => 'maths',
                'content' => '',
                'image_name' => NULL,
                'image_path' => NULL,
                'thumb_path' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'order_seq' => NULL,
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-11-12 07:18:43',
                'updated_at' => '2020-11-12 07:18:43',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => 'cd9b61e8-d8e5-425c-8ade-e0d4fa4beb3f',
                'paper_category_id' => NULL,
                'title' => 'VR',
                'slug' => 'vr',
                'content' => '',
                'image_name' => NULL,
                'image_path' => NULL,
                'thumb_path' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'order_seq' => NULL,
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-11-12 07:18:43',
                'updated_at' => '2020-11-12 07:18:43',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => '58240bf9-5d3f-4842-ae9c-1b3bc6256d88',
                'paper_category_id' => NULL,
                'title' => 'NVR',
                'slug' => 'nvr',
                'content' => '',
                'image_name' => NULL,
                'image_path' => NULL,
                'thumb_path' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'order_seq' => NULL,
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-11-12 07:18:44',
                'updated_at' => '2020-11-12 07:18:44',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'uuid' => '50180977-c971-4cd2-acbd-dae0638f68a1',
                'paper_category_id' => NULL,
                'title' => 'English',
                'slug' => 'english',
                'content' => '',
                'image_name' => NULL,
                'image_path' => NULL,
                'thumb_path' => NULL,
                'extension' => NULL,
                'mime_type' => NULL,
                'order_seq' => NULL,
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-11-12 07:18:44',
                'updated_at' => '2020-11-12 07:18:44',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}