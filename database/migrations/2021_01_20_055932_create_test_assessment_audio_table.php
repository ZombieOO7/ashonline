<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestAssessmentAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_assessment_audio', function (Blueprint $table) {
            $table->unsignedBigInteger('test_assessment_id')->nullable()->comment='pk of test_assessment table';
            $table->foreign('test_assessment_id')->references('id')->on('test_assessments')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('test_assessment_audio');
    }
}
