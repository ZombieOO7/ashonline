<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResizeImageColumnsToPastPaperQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('past_paper_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('past_paper_questions', 'resize_question_image')) {
                $table->string('resize_question_image')->nullable();
            }
            if (!Schema::hasColumn('past_paper_questions', 'resize_answer_image')) {
                $table->string('resize_answer_image')->nullable();
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
            if (Schema::hasColumn('past_paper_questions', 'resize_question_image')) {
                $table->dropColumn('resize_question_image');
            }
            if (Schema::hasColumn('past_paper_questions', 'resize_answer_image')) {
                $table->dropColumn('resize_answer_image');
            }
        });
    }
}
