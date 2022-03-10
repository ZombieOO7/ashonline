<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnToStudentTestPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_test_papers', function (Blueprint $table) {
            if (!Schema::hasColumn('student_test_papers', 'status')) {
                $table->smallInteger('status')->default(1)->comment='1=complete, 2=inprogress,3=evaluate';
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
