<?php

use Illuminate\Database\Seeder;

class SubjectPaperCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subject_paper_categories')->delete();
        
        \DB::table('subject_paper_categories')->insert(array (
            0 => 
            array (
                'paper_category_id' => 1,
                'subject_id' => 6,
            ),
            1 => 
            array (
                'paper_category_id' => 2,
                'subject_id' => 6,
            ),
            2 => 
            array (
                'paper_category_id' => 1,
                'subject_id' => 5,
            ),
            3 => 
            array (
                'paper_category_id' => 2,
                'subject_id' => 5,
            ),
            4 => 
            array (
                'paper_category_id' => 1,
                'subject_id' => 7,
            ),
            5 => 
            array (
                'paper_category_id' => 2,
                'subject_id' => 7,
            ),
            6 => 
            array (
                'paper_category_id' => 1,
                'subject_id' => 8,
            ),
            7 => 
            array (
                'paper_category_id' => 2,
                'subject_id' => 9,
            ),
            8 => 
            array (
                'paper_category_id' => 1,
                'subject_id' => 10,
            ),
            9 => 
            array (
                'paper_category_id' => 20,
                'subject_id' => 12,
            ),
            10 => 
            array (
                'paper_category_id' => 21,
                'subject_id' => 13,
            ),
            11 => 
            array (
                'paper_category_id' => 22,
                'subject_id' => 14,
            ),
            12 => 
            array (
                'paper_category_id' => 5,
                'subject_id' => 15,
            ),
            13 => 
            array (
                'paper_category_id' => 24,
                'subject_id' => 16,
            ),
            14 => 
            array (
                'paper_category_id' => 6,
                'subject_id' => 17,
            ),
            15 => 
            array (
                'paper_category_id' => 4,
                'subject_id' => 17,
            ),
            16 => 
            array (
                'paper_category_id' => 1,
                'subject_id' => 18,
            ),
            17 => 
            array (
                'paper_category_id' => 5,
                'subject_id' => 19,
            ),
            18 => 
            array (
                'paper_category_id' => 4,
                'subject_id' => 19,
            ),
            19 => 
            array (
                'paper_category_id' => 3,
                'subject_id' => 19,
            ),
            20 => 
            array (
                'paper_category_id' => 7,
                'subject_id' => 20,
            ),
            21 => 
            array (
                'paper_category_id' => 33,
                'subject_id' => 20,
            ),
            22 => 
            array (
                'paper_category_id' => 5,
                'subject_id' => 21,
            ),
            23 => 
            array (
                'paper_category_id' => 31,
                'subject_id' => 21,
            ),
            24 => 
            array (
                'paper_category_id' => 3,
                'subject_id' => 21,
            ),
        ));
        
        
    }
}