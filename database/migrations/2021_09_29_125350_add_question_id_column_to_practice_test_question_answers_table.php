<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionIdColumnToPracticeTestQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_test_question_answers', function (Blueprint $table) {
            if (Schema::hasColumn('practice_test_question_answers', 'question_id')) {
                $table->dropForeign('practice_test_question_answers_question_id_foreign');
                $table->dropColumn('question_id');
            }
            if (Schema::hasColumn('practice_test_question_answers', 'question_list_id')) {
                $table->dropForeign('practice_test_question_answers_question_list_id_foreign');
                $table->dropColumn('question_list_id');
            }
        });
        Schema::table('practice_test_question_answers', function (Blueprint $table) {
            if(!Schema::hasColumn('practice_test_question_answers', 'question_id')){
                $table->unsignedBigInteger('question_id')->nullable()->comment('pk of practice_questions table');
                $table->foreign('question_id')->references('id')->on('practice_questions')->onUpdate('cascade')->onDelete('cascade');
            }
            if(!Schema::hasColumn('practice_test_question_answers', 'question_list_id')){
                $table->unsignedBigInteger('question_list_id')->nullable()->comment('pk of practice_question_lists table');
                $table->foreign('question_list_id')->references('id')->on('practice_question_lists')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('practice_test_question_answers', function (Blueprint $table) {
            //
        });
    }
}
