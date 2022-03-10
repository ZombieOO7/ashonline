<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssessmentQuestionIdColumnToReportProblems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_problems', function (Blueprint $table) {
            if (Schema::hasColumn('report_problems', 'question_list_id')) {
                $table->dropForeign('report_problems_question_list_id_foreign');
                $table->dropColumn('question_list_id');
            }
        });
        Schema::table('report_problems', function (Blueprint $table) {
            if(!Schema::hasColumn('report_problems', 'question_list_id')){
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
        Schema::table('report_problems', function (Blueprint $table) {
        });
    }
}
