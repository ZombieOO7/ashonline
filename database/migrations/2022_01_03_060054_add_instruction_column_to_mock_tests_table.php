<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInstructionColumnToMockTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_tests', function (Blueprint $table) {
            if (!Schema::hasColumn('mock_tests', 'instruction')) {
                $table->text('instruction')->nullable();
            }
        });
        Schema::table('mock_tests', function (Blueprint $table) {
            if (Schema::hasColumn('mock_tests', 'header')) {
                $table->dropColumn('header');
            }
        });
        Schema::table('mock_tests', function (Blueprint $table) {
            if (Schema::hasColumn('mock_tests', 'summury')) {
                $table->dropColumn('summury');
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
            if (Schema::hasColumn('mock_tests', 'instruction')) {
                $table->dropColumn('instruction');
            }
        });
    }
}
