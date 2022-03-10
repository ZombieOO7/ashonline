<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->comment = 'encrypted id';
            $table->tinyInteger('type')->default('1')->comment = '1 = Home, 2 = About Us, 3 = Tutions';
            $table->integer('sub_type')->default('1')->comment = '1 = Home Banner Section, 2 = Home Designed By Experts, 3 = Home All Subjects, 4 = Home Exam Format, 5 = Home Exam Styles, 6 = About Us Banner Section, 7 = About Us Main Section, 8 = About Us We Provide, 9 = Mind Behind The Scene, 10 = Sub Section, 11 = Tutions Banner Section, 12 = Tutions Main Section, 13 = Tutions Sub Section';
            $table->text('title')->nullable();
            $table->text('slug')->nullable();
            $table->text('sub_title')->nullable();
            $table->longText('content')->nullable();
            $table->text('note')->nullable();
            $table->text('subject_title_1')->nullable();
            $table->text('subject_title_1_content')->nullable();
            $table->text('subject_title_2')->nullable();
            $table->text('subject_title_2_content')->nullable();
            $table->text('subject_title_3')->nullable();
            $table->text('subject_title_3_content')->nullable();
            $table->text('subject_title_4')->nullable();
            $table->text('subject_title_4_content')->nullable();
            $table->text('exam_format_title_1')->nullable();
            $table->text('exam_format_title_1_content')->nullable();
            $table->text('exam_format_title_2')->nullable();
            $table->text('exam_format_title_2_content')->nullable();
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
        Schema::dropIfExists('blocks');
    }
}
