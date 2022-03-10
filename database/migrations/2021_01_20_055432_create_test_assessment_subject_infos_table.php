<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestAssessmentSubjectInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_assessment_subject_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id')->nullable()->comment = 'Pk of subjects table';
            $table->unsignedBigInteger('test_assessment_id')->nullable()->comment = 'Pk of test_assessments table';
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('test_assessment_id')->references('id')->on('test_assessments')->onDelete('cascade')->onUpdate('cascade');
            $table->string('time')->nullable()->default('0');
            $table->integer('questions')->nullable()->default('0');
            $table->integer('report_question')->nullable()->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_assessment_subject_infos');
    }
}
