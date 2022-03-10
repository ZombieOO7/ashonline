<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPracticeQuestionIdColumnToReportProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_problems', function (Blueprint $table) {
            if (!Schema::hasColumn('report_problems', 'practice_question_id')) {
                $table->unsignedBigInteger('practice_question_id')->nullable();
                $table->foreign('practice_question_id')->references('id')->on('practice_questions')
                ->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::table('report_problems', function (Blueprint $table) {
            if (Schema::hasColumn('report_problems', 'practice_question_id')) {
                $table->dropForeign('report_problems_practice_question_id_foreign');
                $table->dropColumn('practice_question_id');
            }
        });
    }
}
