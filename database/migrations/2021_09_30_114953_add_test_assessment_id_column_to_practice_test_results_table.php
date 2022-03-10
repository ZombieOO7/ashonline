<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestAssessmentIdColumnToPracticeTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_test_results', function (Blueprint $table) {
            if (!Schema::hasColumn('practice_test_results', 'test_assessment_id')) {
                $table->unsignedBigInteger('test_assessment_id')->nullable()->comment='pk of test_assessments table';
                $table->foreign('test_assessment_id')->references('id')->on('test_assessments')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('practice_test_results', function (Blueprint $table) {
            //
        });
    }
}
