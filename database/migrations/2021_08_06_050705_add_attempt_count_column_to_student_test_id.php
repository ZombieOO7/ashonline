<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttemptCountColumnToStudentTestId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_tests', function (Blueprint $table) {
            if (!Schema::hasColumn('student_tests', 'attempt_count')) {
                $table->double('attempt_count')->default(0)->nullable();
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
        Schema::table('student_test_id', function (Blueprint $table) {
            //
        });
    }
}
