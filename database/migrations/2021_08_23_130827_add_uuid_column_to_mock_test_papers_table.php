<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUuidColumnToMockTestPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_test_papers', function (Blueprint $table) {
            if (!Schema::hasColumn('mock_test_papers', 'uuid')) {
                $table->uuid('uuid')->unique()->nullable();
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
        Schema::table('mock_test_papers', function (Blueprint $table) {
            //
        });
    }
}
