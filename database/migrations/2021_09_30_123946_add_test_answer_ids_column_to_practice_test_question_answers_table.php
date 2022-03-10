<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestAnswerIdsColumnToPracticeTestQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_test_question_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('practice_test_question_answers', 'answer_ids')) {
                $table->string('answer_ids')->nullable()->comment('comma separated ids');
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
        Schema::table('practice_test_question_answers', function (Blueprint $table) {
            //
        });
    }
}
