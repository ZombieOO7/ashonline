<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->integer('payment_type')->nullable()->default('1')->comment = '1 Stripe, 2 Paypal';
            $table->string('stripe_key')->nullable();
            $table->string('stripe_secret')->nullable();
            $table->string('stripe_currency')->nullable();
            $table->string('stripe_mode')->nullable();
            $table->string('paypal_client_id')->nullable();
            $table->string('paypal_sandbox_api_username')->nullable();
            $table->string('paypal_sandbox_api_password')->nullable();
            $table->string('paypal_sandbox_api_secret')->nullable();
            $table->string('paypal_currency')->nullable();
            $table->string('paypal_sandbox_api_certificate')->nullable();
            $table->string('paypal_mode')->nullable();
            $table->integer('status')->nullable()->default('1')->comment = '0 Inactive/1 Active';
            $table->tinyInteger('project_type')->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_settings');
    }
}
