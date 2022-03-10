<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMockTestSubjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mock_test_subject_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mock_test_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('time')->nullable();
            $table->integer('questions')->nullable();
            $table->integer('report_question')->nullable();
            $table->timestamps();
            $table->foreign('mock_test_id')->references('id')->on('mock_tests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mock_test_subject_details');
    }
}
