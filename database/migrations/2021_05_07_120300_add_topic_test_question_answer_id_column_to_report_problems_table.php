<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTopicTestQuestionAnswerIdColumnToReportProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_problems', function (Blueprint $table) {
            if (!Schema::hasColumn('report_problems', 'practice_test_question_answer')) {
                $table->unsignedBigInteger('practice_test_question_answer_id')->nullable()->comment='pk of practice_test_question_answers table';
                $table->foreign('practice_test_question_answer_id')->references('id')->on('practice_test_question_answers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('report_problems', function (Blueprint $table) {
            //
        });
    }
}
