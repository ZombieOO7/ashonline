<?php

use Illuminate\Database\Seeder;

class FaqCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('faq_categories')->delete();
        
        \DB::table('faq_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => '429841c2-2199-11ea-b13f-000c29f164c3',
                'title' => 'Payment FAQs',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-06-25 12:54:50',
                'updated_at' => '2020-06-25 12:54:50',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => '6b717ed5-219b-11ea-b13f-000c29f164c3',
                'title' => 'Technical FAQs',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-06-25 12:55:15',
                'updated_at' => '2020-06-25 12:55:15',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => 'f62db5d2-218c-11ea-b13f-000c29f164c3',
                'title' => 'PDF Related FAQs',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-06-25 12:55:41',
                'updated_at' => '2020-06-25 12:55:41',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}