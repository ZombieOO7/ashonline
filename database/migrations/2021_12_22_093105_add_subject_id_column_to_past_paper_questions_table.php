<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectIdColumnToPastPaperQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('past_paper_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('past_paper_questions', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable();
                $table->foreign('subject_id')->references('id')->on('subjects')
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
        Schema::table('past_paper_questions', function (Blueprint $table) {
            if (Schema::hasColumn('past_paper_questions', 'subject_id')) {
                $table->dropForeign('past_paper_questions_subject_id_foreign');
                $table->dropColumn('subject_id');
            }
        });
    }
}
