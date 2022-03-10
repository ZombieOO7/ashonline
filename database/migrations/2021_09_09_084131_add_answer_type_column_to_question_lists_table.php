<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnswerTypeColumnToQuestionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_lists', function (Blueprint $table) {
            if (!Schema::hasColumn('question_lists', 'answer_type')) {
                $table->integer('answer_type')->default(1)->nullable()->comment('1=Single correct answer 2=Multiple correct answer');
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
