<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTopicIdAndQuestionNoColumnToPastPaperQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('past_paper_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('past_paper_questions', 'topic_id')) {
                $table->unsignedBigInteger('topic_id')->nullable();
                $table->foreign('topic_id')->references('id')->on('topics')->cascadeOnDelete()->cascadeOnUpdate();
            }
            if (!Schema::hasColumn('past_paper_questions', 'question_no')) {
                $table->string('question_no')->nullable();
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
        Schema::table('past_paper_questions', function (Blueprint $table) {
            //
        });
    }
}
