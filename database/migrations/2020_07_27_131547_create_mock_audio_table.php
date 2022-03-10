<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMockAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mock_audio', function (Blueprint $table) {
            $table->unsignedBigInteger('mock_test_id')->nullable();
            $table->foreign('mock_test_id')->references('id')->on('mock_tests')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('seq')->default(1)->nullable();
            $table->string('interval')->nullable();
            $table->string('audio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mock_audio');
    }
}
