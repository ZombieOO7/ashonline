<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasedMockTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_mock_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->comment = 'encrypted id';
            $table->unsignedBigInteger('mock_test_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('mock_test_id')->references('id')->on('mock_tests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->smallInteger('status')->nullable()->default('0')->comment = '0 =pending, 1=activated, 2=completed';
            $table->smallInteger('project_type')->nullable()->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->smallInteger('feedback_status')->nullable()->default('0')->comment = '0 = No, 1 = Yes';
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchased_mock_tests');
    }
}
