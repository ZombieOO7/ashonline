<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsMocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_mocks', function (Blueprint $table) {
            $table->unsignedBigInteger('cms_id')->nullable();
            $table->unsignedBigInteger('mock_test_id')->nullable();
            $table->foreign('cms_id')->references('id')->on('cms')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mock_test_id')->references('id')->on('mock_tests')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_mocks');
    }
}
