<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResizeImageColumnsToQuestionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_lists', function (Blueprint $table) {
            if (!Schema::hasColumn('question_lists', 'resize_full_image')) {
                $table->text('resize_full_image')->nullable();
            }
            if (!Schema::hasColumn('question_lists', 'resize_question_image')) {
                $table->text('resize_question_image')->nullable();
            }
            if (!Schema::hasColumn('question_lists', 'resize_answer_image')) {
                $table->text('resize_answer_image')->nullable();
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
