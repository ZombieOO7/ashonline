<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentTestResultIdColumnToStudentTestQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_test_question_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('student_test_question_answers', 'student_test_result_id')) {
                $table->unsignedBigInteger('student_test_result_id')->nullable()->comment='pk of student_tests table';
                $table->foreign('student_test_result_id')->references('id')->on('student_test_results')->onDelete('cascade')->onUpdate('cascade');
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
            if (Schema::hasColumn('student_test_question_answers', 'student_test_result_id')) {
                $table->dropColumn('student_test_result_id');
            }
        });
    }
}
