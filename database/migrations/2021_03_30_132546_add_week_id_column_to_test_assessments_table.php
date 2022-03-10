<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWeekIdColumnToTestAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_assessments', function (Blueprint $table) {
            if (!Schema::hasColumn('test_assessments', 'week')) {
                $table->string('week')->nullable();
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
            if (Schema::hasColumn('test_assessments', 'week')) {
                $table->dropColumn('week');
            }
        });
    }
}
