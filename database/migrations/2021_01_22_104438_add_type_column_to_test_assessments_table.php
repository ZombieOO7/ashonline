<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeColumnToTestAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_assessments', function (Blueprint $table) {
            if (!Schema::hasColumn('test_assessments', 'type')) {
                $table->smallInteger('type')->default(1)->comment='1=Test Assessmet, 2=Practice Exam';
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
        Schema::table('test_assessments', function (Blueprint $table) {
            if (Schema::hasColumn('test_assessments', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
}
