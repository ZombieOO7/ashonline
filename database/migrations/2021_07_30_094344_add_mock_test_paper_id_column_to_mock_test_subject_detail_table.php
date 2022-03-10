<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMockTestPaperIdColumnToMockTestSubjectDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_test_subject_details', function (Blueprint $table) {
            if(!Schema::hasColumn('mock_test_subject_details', 'mock_test_paper_id')) {
                $table->unsignedBigInteger('mock_test_paper_id')->nullable()->comment='pk of mock_test_papers';
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
        Schema::table('mock_test_subject_detail', function (Blueprint $table) {
            //
        });
    }
}
