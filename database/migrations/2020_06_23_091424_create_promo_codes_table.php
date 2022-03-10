<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('title')->nullable();
            $table->text('code')->nullable();
            $table->double('amount_1')->nullable();
            $table->double('amount_2')->nullable();
            $table->double('max_amt_discount')->nullable();
            $table->double('discount')->nullable();
            $table->double('discount_1')->nullable();
            $table->double('discount_2')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->tinyInteger('status')->default('1')->comment = '0 Inactive/1 Active';
            $table->tinyInteger('type')->default('1')->nullable()->comment = '1 General/2 Specific';
            $table->tinyInteger('project_type')->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
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
        Schema::dropIfExists('promo_codes');
    }
}
