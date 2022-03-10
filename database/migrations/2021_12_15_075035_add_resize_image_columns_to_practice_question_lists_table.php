<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResizeImageColumnsToPracticeQuestionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_question_lists', function (Blueprint $table) {
            if (!Schema::hasColumn('practice_question_lists', 'resize_full_image')) {
                $table->string('resize_full_image')->nullable();
            }
            if (!Schema::hasColumn('practice_question_lists', 'resize_question_image')) {
                $table->string('resize_question_image')->nullable();
            }
            if (!Schema::hasColumn('practice_question_lists', 'resize_answer_image')) {
                $table->string('resize_answer_image')->nullable();
            }
            if (!Schema::hasColumn('practice_question_lists', 'instruction')) {
                $table->text('instruction')->nullable();
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
        Schema::table('practice_question_lists', function (Blueprint $table) {
            //
        });
    }
}
