<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeByTopicQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_by_topic_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('subject_id')->nullable()->comment('pk of subjects table');
            $table->foreign('subject_id')->references('id')->on('subjects')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('no_of_questions')->default('0')->nullable();
            $table->string('question_no')->nullable();
            $table->text('question')->nullable();
            $table->text('instruction')->nullable();
            $table->smallInteger('type')->default('1')->comment('1 = MCQ, 2 = Comprehensive, 3 = Cloze');
            $table->double('marks')->default('0')->nullable();
            $table->text('explanation')->nullable();
            $table->string('image')->nullable();
            $table->string('question_image')->nullable();
            $table->string('answer_image')->nullable();
            $table->string('resize_full_image')->nullable();
            $table->string('resize_question_image')->nullable();
            $table->string('resize_answer_image')->nullable();
            $table->smallInteger('answer_type')->default('1')->comment('1=MCQ, 2=Standard')->nullable();
            $table->smallInteger('status')->default('1')->comment('0 for inactive, 1 for active')->nullable();
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
        Schema::dropIfExists('practice_by_topic_questions');
    }
}
