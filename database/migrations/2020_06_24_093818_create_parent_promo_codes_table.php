<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentPromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_promo_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->comment('pk of promo_codes table');
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('promo_code_id')->nullable()->comment('pk of promo_codes table');
            $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('project_type')->nullable()->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
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
        Schema::dropIfExists('parent_promo_codes');
    }
}
