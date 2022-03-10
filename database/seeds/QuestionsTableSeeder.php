<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('questions')->delete();
        
        \DB::table('questions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => '870dd088-4573-462d-ae94-766ff9885935',
                'question_title' => '',
                'subject_id' => 1,
                'topic_id' => 1,
                'hint' => '',
                'total_ans' => 0.0,
                'type' => 1,
                'active' => 1,
                'project_type' => 0,
                'is_passage' => 0,
                'is_entry_type' => 1,
                'created_at' => '2021-03-05 08:11:59',
                'updated_at' => '2021-03-05 08:11:59',
                'deleted_at' => NULL,
                'correct_answer' => 0.0,
                'incorrect_answer' => 0.0,
                'no_of_students' => 0.0,
                'question_type' => 1,
            ),
        ));
        
        
    }
}