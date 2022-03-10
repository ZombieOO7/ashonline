<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_assessments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable()->unique()->comment = 'encrypted id';
            $table->unsignedBigInteger('exam_board_id')->nullable()->comment='pk of exam_boards table';
            $table->unsignedBigInteger('grade_id')->nullable()->comment='pk of grades table';
            $table->unsignedBigInteger('image_id')->nullable()->comment='pk of images table';
            $table->unsignedBigInteger('school_id')->nullable()->comment='pk of schools table';
            $table->unsignedBigInteger('topic_id')->nullable()->comment='pk of topics table';
            $table->foreign('exam_board_id')->references('id')->on('exam_boards')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->text('summury')->nullable();
            $table->text('header')->nullable();
            $table->tinyInteger('project_type')->nullable()->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->tinyInteger('stage_id')->nullable()->default('0')->comment = '1 = Stage 1 MCQ, 2 = Stage 2 Standard';
            $table->tinyInteger('status')->nullable()->default('1')->comment = '0 InActive/1 Active';
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
        Schema::dropIfExists('test_assessments');
    }
}
