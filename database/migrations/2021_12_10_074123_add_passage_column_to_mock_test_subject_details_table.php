<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPassageColumnToMockTestSubjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_test_subject_details', function (Blueprint $table) {
            if(!Schema::hasColumn('mock_test_subject_details','passage')){
                $table->string('passage')->nullable();
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
