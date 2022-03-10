<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestAssessmentIdColumnToStudentTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_tests', function (Blueprint $table) {
            if (!Schema::hasColumn('student_tests', 'test_assessment_id')) {
                $table->unsignedBigInteger('test_assessment_id')->nullable()->comment='PK of test_assessments';
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
        Schema::table('student_tests', function (Blueprint $table) {
            if (Schema::hasColumn('student_tests', 'test_assessment_id')) {
                $table->dropForeign('student_tests_test_assessment_id_foreign');
                $table->dropColumn('test_assessment_id');
            }
        });
    }
}
