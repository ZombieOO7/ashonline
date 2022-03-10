<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeByTopicQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_by_topic_question_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('student_id')->nullable()->comment('pk of students');
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('practice_exam_id')->nullable()->comment('pk of practice_exams');
            $table->foreign('practice_exam_id')->references('id')->on('practice_exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('question_id')->nullable()->comment('pk of practice_by_topic_questions table');
            $table->foreign('question_id')->references('id')->on('practice_by_topic_questions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('subject_id')->nullable()->comment('pk of subjects table');
            $table->smallInteger('is_correct')->comment('1=correct,2=incorrect');
            $table->smallInteger('is_attempted')->comment('0=No,1=Yes');
            $table->double('time_taken')->nullable();
            $table->unsignedBigInteger('practice_by_topic_result_id')->nullable();
            $table->foreign('practice_by_topic_result_id')->references('id')->on('practice_by_topic_results')->cascadeOnUpdate()->cascadeOnDelete();
            $table->smallInteger('mark_as_review')->comment('0=No,1=Yes');
            $table->string('answer_ids')->nullable();
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
        Schema::dropIfExists('practice_by_topic_question_answers');
    }
}
