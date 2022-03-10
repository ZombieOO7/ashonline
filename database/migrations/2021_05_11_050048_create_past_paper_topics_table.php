<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastPaperTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('past_paper_topics', function (Blueprint $table) {
            $table->unsignedBigInteger('past_paper_question_id')->nullable();
            $table->foreign('past_paper_question_id')->references('id')->on('past_paper_questions')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('topic_id')->nullable();
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('past_paper_topics');
    }
}
