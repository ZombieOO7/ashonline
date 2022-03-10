<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('order_no')->nullable();
            $table->double('amount',8,2)->default(0.00);
            $table->double('discount',8,2)->default(0.00);
            $table->tinyInteger('is_remind')->default('0')->comment = '0 NO/1 YES';
            $table->unsignedBigInteger('promo_code_id')->nullable()->comment('pk of promo_codes table');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('pk of promo_codes table');
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('status')->default('1')->comment = '0 Inactive/1 Active';
            $table->tinyInteger('project_type')->nullable()->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
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
        Schema::dropIfExists('orders');
    }
}
