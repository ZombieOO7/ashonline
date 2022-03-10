<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToStudentTestPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_test_papers', function (Blueprint $table) {
            if (!Schema::hasColumn('student_test_papers', 'is_reset')) {
                $table->smallInteger('is_reset')->default(0)->comment="0 = No, 1 = Yes";
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
