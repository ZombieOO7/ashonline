<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionNoColumnToQuestionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_lists', function (Blueprint $table) {
            if (!Schema::hasColumn('question_lists', 'question_no')) {
                $table->string('question_no')->nullable();
            }
            if (!Schema::hasColumn('question_lists', 'question_image')) {
                $table->string('question_image')->nullable();
            }
            if (!Schema::hasColumn('question_lists', 'answer_image')) {
                $table->string('answer_image')->nullable();
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
