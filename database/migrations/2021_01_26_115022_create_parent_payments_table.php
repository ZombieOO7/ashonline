<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable()->comment = 'pk of parents table';
            $table->unsignedBigInteger('subscription_id')->nullable()->comment = 'pk of subscriptions table';
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('transaction_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('amount')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->smallInteger('method')->nullable()->comment='1=stripe, 2=paypal';
            $table->smallInteger('status')->default('0')->comment='0 =inactive, 1 = active';
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
        Schema::dropIfExists('parent_payments');
    }
}
