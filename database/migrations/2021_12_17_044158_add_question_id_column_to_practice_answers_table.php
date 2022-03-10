<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionIdColumnToPracticeAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('practice_answers', 'question_id')) {
                $table->unsignedBigInteger('question_id')->nullable()->comment('pk of practice_questions table');
                $table->foreign('question_id')->references('id')->on('practice_questions')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::table('practice_answers', function (Blueprint $table) {
            //
        });
    }
}
