<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMockTestOrderHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mock_test_order_history', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->unsigned()->nullable()->comment = 'PK of orders';
            $table->unsignedBigInteger('mock_test_id')->nullable()->comment('P.K. of mock_tests table');
            $table->tinyInteger('status')->default('1')->comment = '0 Inactive/1 Active';
            $table->bigInteger('parent_id')->nullable()->comment('P.K. of parents table');
            $table->foreign('mock_test_id')->references('id')->on('mock_tests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mock_test_order_history');
    }
}
