<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionListIdColumnToStudentTestQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_test_question_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('student_test_question_answers', 'question_list_id')) {
                $table->unsignedBigInteger('question_list_id')->nullable()->comment='pk of question_list table';
                $table->foreign('question_list_id')->references('id')->on('question_lists')->onDelete('cascade')->onUpdate('cascade');
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
            if (Schema::hasColumn('student_test_question_answers', 'question_list_id')) {
                $table->dropForeign('student_test_question_answers_question_list_id_foreign');
                $table->dropColumn('question_list_id');
            }
        });
    }
}
