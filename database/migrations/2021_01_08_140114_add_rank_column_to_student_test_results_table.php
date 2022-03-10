<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRankColumnToStudentTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_test_results', function (Blueprint $table) {
            if (!Schema::hasColumn('student_test_results', 'rank')) {
                $table->double('rank')->nullable()->default(0);
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
            if (Schema::hasColumn('student_test_results', 'rank')) {
                $table->dropColumn('rank');
            }
        });
    }
}
