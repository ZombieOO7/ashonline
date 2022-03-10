<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('currency')->nullable();
            $table->double('price')->nullable()->default(0);
            $table->string('payment_date')->nullable();
            $table->smallInteger('status')->default(1)->comment = '0 = Inactive, 1= Active';
            $table->smallInteger('type')->default(1)->comment = '1 =monthly';
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
        Schema::dropIfExists('subscriptions');
    }
}
