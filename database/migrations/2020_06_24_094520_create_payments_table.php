<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable()->comment = 'PK of orders';
            $table->string('currency',50)->nullable();
            $table->double('amount',8,2)->default(0.00);
            $table->string('payment_date')->nullable();
            $table->tinyInteger('method')->default('1')->comment = '1=Paypal';
            $table->tinyInteger('status')->default('0')->comment = '0 Unpiad/1 Paid';
            $table->tinyInteger('project_type')->nullable()->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('payments');
    }
}
