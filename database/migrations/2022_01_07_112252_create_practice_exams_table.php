<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('exam_board_id')->nullable()->comment='pk of exam_boards table';
            $table->foreign('exam_board_id')->references('id')->on('exam_boards')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('grade_id')->nullable()->comment='pk of grades table';
            $table->foreign('grade_id')->references('id')->on('grades')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('subject_id')->nullable()->comment='pk of subjects table';
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('topic_id')->nullable()->comment='pk of topics table';
            $table->foreign('topic_id')->references('id')->on('topics')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('questions')->nullable();
            $table->string('audio_1')->nullable();
            $table->string('audio_2')->nullable();
            $table->string('audio_3')->nullable();
            $table->string('audio_4')->nullable();
            $table->smallInteger('status')->default('1')->comment('1=active, 2=inactive');
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
        Schema::dropIfExists('practice_exams');
    }
}
