<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentTestIdColumnToStudentTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_test_results', function (Blueprint $table) {
            if (!Schema::hasColumn('student_test_results', 'student_test_id')) {
                $table->unsignedBigInteger('student_test_id')->nullable()->comment='pk of student_tests table';
                $table->foreign('student_test_id')->references('id')->on('student_tests')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('student_test_results', function (Blueprint $table) {
            if (Schema::hasColumn('student_test_results', 'student_test_id')) {
                $table->dropColumn('student_test_id');
            }
        });
    }
}
