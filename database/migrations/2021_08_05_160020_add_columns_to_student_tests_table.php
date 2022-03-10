<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToStudentTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_tests', function (Blueprint $table) {
            if (!Schema::hasColumn('student_tests', 'questions')) {
                $table->double('questions')->default(0)->nullable();
            }
            if (!Schema::hasColumn('student_tests', 'attempted')) {
                $table->double('attempted')->default(0)->nullable();
            }
            if (!Schema::hasColumn('student_tests', 'correctly_answered')) {
                $table->double('correctly_answered')->default(0)->nullable();
            }
            if (!Schema::hasColumn('student_tests', 'unanswered')) {
                $table->double('unanswered')->default(0)->nullable();
            }
            if (!Schema::hasColumn('student_tests', 'overall_result')) {
                $table->double('overall_result')->default(0)->nullable();
            }
            if (!Schema::hasColumn('student_tests', 'total_marks')) {
                $table->double('total_marks')->default(0)->nullable();
            }
            if (!Schema::hasColumn('student_tests', 'obtained_marks')) {
                $table->double('obtained_marks')->default(0)->nullable();
            }
            if (!Schema::hasColumn('student_tests', 'rank')) {
                $table->double('rank')->default(0)->nullable();
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
            //
        });
    }
}
