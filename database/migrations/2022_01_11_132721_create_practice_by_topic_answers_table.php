<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeByTopicAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_by_topic_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('question_id')->nullable()->comment('pk of practice_by_topic_questions table');
            $table->foreign('question_id')->references('id')->on('practice_by_topic_questions')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('answer')->nullable();
            $table->smallInteger('is_correct')->commnet('0=incorrect,1=correct')->nullable();
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
        Schema::dropIfExists('practice_by_topic_answers');
    }
}
