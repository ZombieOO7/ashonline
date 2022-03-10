<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssessmentQuestionIdColumnToTestAssessmentSubjectInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_assessment_subject_infos', function (Blueprint $table) {
            if (Schema::hasColumn('test_assessment_subject_infos', 'question_id')) {
                $table->dropForeign('test_assessment_subject_infos_question_id_foreign');
                $table->dropColumn('question_id');
            }
        });
        Schema::table('test_assessment_subject_infos', function (Blueprint $table) {
            if(!Schema::hasColumn('test_assessment_subject_infos', 'question_id')){
                $table->unsignedBigInteger('question_id')->nullable()->comment('pk of practice_questions table');
                $table->foreign('question_id')->references('id')->on('practice_questions')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('test_assessment_subject_infos', function (Blueprint $table) {
            //
        });
    }
}
