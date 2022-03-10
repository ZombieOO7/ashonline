<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestAssessmentQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_assessment_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id')->nullable()->comment = 'Pk of questions table';
            $table->unsignedBigInteger('subject_id')->nullable()->comment = 'Pk of subjects table';
            $table->unsignedBigInteger('test_assessment_id')->nullable()->comment = 'Pk of test_assessments table';
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('test_assessment_id')->references('id')->on('test_assessments')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_assessment_questions');
    }
}
