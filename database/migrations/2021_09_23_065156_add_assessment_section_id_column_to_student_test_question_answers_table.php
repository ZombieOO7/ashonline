<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssessmentSectionIdColumnToStudentTestQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_test_question_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('student_test_question_answers', 'assessment_section_id')) {
                $table->unsignedBigInteger('assessment_section_id')->nullable();
                $table->foreign('assessment_section_id')->references('id')->on('test_assessment_subject_infos')->onDelete('cascade')->onUpdate('cascade');
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
            //
        });
    }
}
