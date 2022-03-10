<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionIdColumnToMockTestSubjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_test_subject_details', function (Blueprint $table) {
            if (!Schema::hasColumn('mock_test_subject_details', 'question_id')) {
                $table->unsignedBigInteger('question_id')->nullable();
                $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade')->onUpdate('cascade');
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
