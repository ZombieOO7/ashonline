<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_topics', function (Blueprint $table) {
            $table->unsignedBigInteger('test_assessment_id')->nullable()->comment='PK of test_assessments table';
            $table->unsignedBigInteger('topic_id')->nullable()->comment='PK of topics table';
            $table->foreign('test_assessment_id')->references('id')->on('test_assessments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_topics');
    }
}
