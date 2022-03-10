<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->comment('encrypted question id');
            $table->longText('question_title')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('topic_id')->nullable();
            $table->foreign('topic_id')->references('id')->on('topics')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('hint')->nullable();
            $table->double('total_ans')->default('0');
            $table->tinyInteger('type')->default('1')->comment('1 = MCQ, 2 = Comprehensive, 3 = Cloze');
            $table->tinyInteger('active')->default('1')->comment('0 for inactive, 1 for active');
            $table->tinyInteger('project_type')->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->tinyInteger('is_passage')->default('0')->comment('0 = No, 1 = Yes');
            $table->tinyInteger('is_entry_type')->default('1')->comment('1 = Excel, 2 = Manually');
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
        Schema::dropIfExists('questions');
    }
}
