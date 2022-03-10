<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionIdColumnToTestAssessmentSubjectInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_assessment_subject_infos', function (Blueprint $table) {
            if (!Schema::hasColumn('test_assessment_subject_infos', 'question_id')) {
                $table->unsignedBigInteger('question_id')->nullable();
                $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade')->onUpdate('cascade');
            }
            if (!Schema::hasColumn('test_assessment_subject_infos', 'uuid')) {
                $table->uuid('uuid')->unique()->nullable();
            }
            if (!Schema::hasColumn('test_assessment_subject_infos', 'name')) {
                $table->text('name')->nullable();
            }
            if (!Schema::hasColumn('test_assessment_subject_infos', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('test_assessment_subject_infos', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('test_assessment_subject_infos', 'instruction_read_time')) {
                $table->string('instruction_read_time')->nullable();
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
