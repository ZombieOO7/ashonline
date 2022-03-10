<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMockTestDetailIdColumnToMockTestSubjectQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_test_subject_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('mock_test_subject_questions', 'mock_test_subject_detail_id')) {
                $table->unsignedBigInteger('mock_test_subject_detail_id')->nullable();
                $table->foreign('mock_test_subject_detail_id')->references('id')
                ->on('mock_test_subject_details')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::table('mock_test_subject_questions', function (Blueprint $table) {
            //
        });
    }
}
