<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowMockColToMockTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_tests', function (Blueprint $table) {
            $table->integer('show_mock')->default(1)->comment("1 = Tution Parent, 2 = Everyone");
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
