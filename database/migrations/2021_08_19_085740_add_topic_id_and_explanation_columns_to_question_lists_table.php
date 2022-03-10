<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTopicIdAndExplanationColumnsToQuestionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_lists', function (Blueprint $table) {
            if (!Schema::hasColumn('question_lists', 'topic_id')) {
                $table->unsignedBigInteger('topic_id')->nullable();
                $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade')->onUpdate('cascade');
            }
            if (!Schema::hasColumn('question_lists', 'explanation')) {
                $table->text('explanation')->nullable();
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
        Schema::table('question_lists', function (Blueprint $table) {
            //
        });
    }
}
