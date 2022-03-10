<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestAssessmentSubjectIdColumnToTestAssessmentQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_assessment_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('test_assessment_questions', 'test_assessment_subject_id')) {
                $table->unsignedBigInteger('test_assessment_subject_id')->nullable()->comment('pk of test_assessment_subject_infos table');
                $table->foreign('test_assessment_subject_id')->references('id')->on('test_assessment_subject_infos')
                ->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::table('test_assessment_questions', function (Blueprint $table) {
            //
        });
    }
}
