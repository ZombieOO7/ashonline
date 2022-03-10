<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsTimeMandatoryColumnToMockTestPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_test_papers', function (Blueprint $table) {
            if (!Schema::hasColumn('mock_test_papers', 'is_time_mandatory')) {
                $table->smallInteger('is_time_mandatory')->nullable()->default(1)->comment('0=No, 1=Yes');
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
            if (Schema::hasColumn('mock_test_papers', 'is_time_mandatory')) {
                $table->dropColumn('is_time_mandatory');
            }
        });
    }
}
