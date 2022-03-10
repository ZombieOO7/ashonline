<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMockTestPaperIdColumnToResultGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('result_grades', function (Blueprint $table) {
            if (!Schema::hasColumn('result_grades', 'mock_test_paper_id')) {
                $table->unsignedBigInteger('mock_test_paper_id')->nullable();
                $table->foreign('mock_test_paper_id')->references('id')->on('mock_test_papers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('result_grades', function (Blueprint $table) {
            //
        });
    }
}
