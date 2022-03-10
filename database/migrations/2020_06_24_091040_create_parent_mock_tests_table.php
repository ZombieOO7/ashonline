<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentMockTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_mock_tests', function (Blueprint $table) {
            $table->unsignedBigInteger('mock_test_id')->nullable()->comment('P.K. of mock_tests table');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('P.K. of parents table');
            $table->foreign('mock_test_id')->references('id')->on('mock_tests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parent_mock_tests');
    }
}
