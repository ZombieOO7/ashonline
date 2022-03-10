<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->unsigned()->nullable()->comment = 'PK of orders';
            $table->unsignedBigInteger('paper_id')->unsigned()->nullable()->comment = 'PK of papers';
            $table->unsignedBigInteger('mock_test_id')->unsigned()->nullable()->comment = 'PK of mock_tests table';
            $table->unsignedBigInteger('version_id')->unsigned()->nullable()->comment = 'PK of paper_versions table';
            $table->tinyInteger('project_type')->nullable()->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->double('price', 8, 2)->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mock_test_id')->references('id')->on('mock_tests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('paper_id')->references('id')->on('papers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
