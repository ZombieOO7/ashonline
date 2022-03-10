<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsResetColumnToPracticeTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_test_results', function (Blueprint $table) {
            if (!Schema::hasColumn('practice_test_results', 'is_reset')) {
                $table->smallInteger('is_reset')->default(0)->nullable()->comment='0=No, 1= Yes';
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
        Schema::table('practice_test_results', function (Blueprint $table) {
            //
        });
    }
}
