<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResizeImageColumnsToPracticeQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('practice_questions', 'total_ans')) {
                $table->double('total_ans')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'no_of_students')) {
                $table->double('no_of_students')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'question_no')) {
                $table->string('question_no')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'instruction')) {
                $table->text('instruction')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'question')) {
                $table->text('question')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'question_image')) {
                $table->string('question_image')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'answer_image')) {
                $table->string('answer_image')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'explanation')) {
                $table->text('explanation')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'marks')) {
                $table->double('marks')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'resize_full_image')) {
                $table->string('resize_full_image')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'resize_question_image')) {
                $table->string('resize_question_image')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'resize_answer_image')) {
                $table->string('resize_answer_image')->nullable();
            }
            if (!Schema::hasColumn('practice_questions', 'answer_type')) {
                $table->smallInteger('answer_type')->nullable()->comment('1=single,2=multiple');
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
        Schema::table('practice_questions', function (Blueprint $table) {
            //
        });
    }
}
