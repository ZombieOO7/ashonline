<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestQuestionAnswerIdColumnToReportProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_problems', function (Blueprint $table) {
            if (!Schema::hasColumn('report_problems', 'question_answer_id')) {
                $table->unsignedBigInteger('question_answer_id')->nullable()->comment='pk of student_test_question_answers table';
                $table->foreign('question_answer_id')->references('id')->on('student_test_question_answers')->onDelete('cascade')->onUpdate('cascade');
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
