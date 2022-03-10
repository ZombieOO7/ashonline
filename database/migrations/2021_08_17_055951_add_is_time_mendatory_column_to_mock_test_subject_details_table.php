<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsTimeMendatoryColumnToMockTestSubjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_test_subject_details', function (Blueprint $table) {
            if (!Schema::hasColumn('mock_test_subject_details', 'is_time_mandatory')) {
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
        Schema::table('mock_test_subject_details', function (Blueprint $table) {
            //
        });
    }
}
