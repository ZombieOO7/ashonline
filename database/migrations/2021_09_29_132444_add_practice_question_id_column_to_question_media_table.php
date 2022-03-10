<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPracticeQuestionIdColumnToQuestionMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_medias', function (Blueprint $table) {
            $table->unsignedBigInteger('practice_question_id')->nullable()->comment('pk of practice_questions table');
            $table->foreign('practice_question_id')->references('id')->on('practice_questions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_medias', function (Blueprint $table) {
            //
        });
    }
}
