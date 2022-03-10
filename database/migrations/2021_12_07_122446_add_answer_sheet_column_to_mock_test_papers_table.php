<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnswerSheetColumnToMockTestPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_test_papers', function (Blueprint $table) {
            if (!Schema::hasColumn('mock_test_papers', 'answer_sheet')) {
                $table->string('answer_sheet')->nullable();
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
