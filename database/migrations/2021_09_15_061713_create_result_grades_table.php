<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->double('excellent_min')->nullable();
            $table->double('excellent_max')->nullable();
            $table->double('very_good_min')->nullable();
            $table->double('very_good_max')->nullable();
            $table->double('good_min')->nullable();
            $table->double('good_max')->nullable();
            $table->double('fair_min')->nullable();
            $table->double('fair_max')->nullable();
            $table->double('improve_min')->nullable();
            $table->double('improve_max')->nullable();
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
        Schema::dropIfExists('result_grades');
    }
}
