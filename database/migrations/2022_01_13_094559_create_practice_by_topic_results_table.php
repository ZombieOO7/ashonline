<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeByTopicResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_by_topic_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('practice_exam_id')->nullable()->comment('pk of practice_exams');
            $table->foreign('practice_exam_id')->references('id')->on('practice_exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('student_id')->nullable()->comment('pk of students');
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('practice_by_topic_test_id')->nullable();
            $table->foreign('practice_by_topic_test_id')->references('id')->on('practice_by_topic_tests')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('questions')->default('0')->nullable();
            $table->integer('attempted')->default('0')->nullable();
            $table->integer('correctly_answered')->default('0')->nullable();
            $table->integer('attempt_count')->default('0')->nullable();
            $table->integer('unanswered')->default('0')->nullable();
            $table->double('overall_result')->default('0')->nullable();
            $table->double('total_marks')->default('0')->nullable();
            $table->double('obtained_marks')->default('0')->nullable();
            $table->integer('rank')->default('0')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practice_by_topic_results');
    }
}
