<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEvaluateAttemptColumnToStudentTestPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_test_papers', function (Blueprint $table) {
            if (!Schema::hasColumn('student_test_papers', 'evaluate_count')) {
                $table->smallInteger('evaluate_count')->default(0)->nullable();
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
        Schema::table('student_test_papers', function (Blueprint $table) {
            //
        });
    }
}
