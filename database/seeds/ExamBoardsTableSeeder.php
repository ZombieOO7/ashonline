<?php

use Illuminate\Database\Seeder;

class ExamBoardsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('exam_boards')->delete();
        
        \DB::table('exam_boards')->insert(array (
            0 => 
            array (
                'id' => 3,
                'uuid' => '429841c2-2199-11ea-b13f-000c29f164c7',
                'title' => 'Super Selective',
                'slug' => 'super_selective',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-05-05 06:43:07',
                'updated_at' => '2020-05-05 06:43:07',
                'deleted_at' => NULL,
                'content' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => '429841c2-2199-11ea-b13f-000c29f164c3',
                'title' => 'CEM',
                'slug' => 'cem',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-05-05 06:42:24',
                'updated_at' => '2020-12-15 08:30:09',
                'deleted_at' => NULL,
                'content' => '<p>aaaa</p>',
            ),
            2 => 
            array (
                'id' => 1,
                'uuid' => '429841c2-2199-11ea-b13f-000c29f164c4',
                'title' => 'GL',
                'slug' => 'gl',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-05-05 06:42:48',
                'updated_at' => '2020-05-05 06:42:48',
                'deleted_at' => NULL,
                'content' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'uuid' => '429841c2-2199-11ea-b13f-000c29f164c6',
                'title' => 'Independent',
                'slug' => 'independent',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-05-05 06:43:33',
                'updated_at' => '2020-12-29 13:33:55',
                'deleted_at' => NULL,
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit lectus ac dolor rhoncus malesuada. Morbi at cursus odio. Morbi pulvinar libero a purus tincidunt pharetra.</p>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit lectus ac dolor rhoncus malesuada. Morbi at cursus odio. Morbi pulvinar libero a purus tincidunt pharetra.</p>',
            ),
        ));
        
        
    }
}