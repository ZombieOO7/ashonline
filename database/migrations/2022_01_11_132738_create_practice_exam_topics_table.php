<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeExamTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_exam_topics', function (Blueprint $table) {
            $table->unsignedBigInteger('practice_exam_id')->nullable()->comment('pk of practice_exams table');
            $table->foreign('practice_exam_id')->references('id')->on('practice_exams')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('topic_id')->nullable()->comment('pk of topics table');
            $table->foreign('topic_id')->references('id')->on('topics')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('no_of_questions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practice_exam_topics');
    }
}
