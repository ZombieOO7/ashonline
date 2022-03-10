<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeTakenColumnToStudentTestQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_test_question_answers', function (Blueprint $table) {
            if(!Schema::hasColumn('student_test_question_answers','time_taken')){
                $table->double('time_taken')->default(0)->nullable()->comment('seconds');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_test_question_answers', function (Blueprint $table) {
            if(Schema::hasColumn('student_test_question_answers','time_taken')){
                $table->dropColumn('time_taken');
            }
        });
    }
}
