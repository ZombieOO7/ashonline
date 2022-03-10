<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsResetColumnToStudentTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_test_results', function (Blueprint $table) {
            if (!Schema::hasColumn('student_test_results', 'is_reset')) {
                $table->tinyInteger('is_reset')->default(0)->comment="0 = No, 1 = Yes";
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
            if (Schema::hasColumn('student_test_results', 'is_reset')) {
                $table->dropColumn('is_reset');
            }
        });
    }
}
