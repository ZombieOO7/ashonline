<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoOfDayColumnToMockTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_tests', function (Blueprint $table) {
            if (!Schema::hasColumn('mock_tests', 'no_of_days')) {
                $table->integer('no_of_days')->default(1)->nullable()->comment('Display report for n number of days');
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
        Schema::table('mock_tests', function (Blueprint $table) {
            //
        });
    }
}
