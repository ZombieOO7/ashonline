<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('paper_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('subject_id')->unsigned()->nullable()->comment = 'P.K. of subjects';
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('exam_type_id')->unsigned()->nullable()->comment = 'P.K. of exam_types';
            $table->foreign('exam_type_id')->references('id')->on('exam_types')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('age_id')->nullable();
            $table->foreign('age_id')->references('id')->on('ages')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('content')->nullable();
            $table->double('price')->nullable()->default('0');
            $table->string('edition')->nullable();
            $table->double('avg_rate')->default('0.0');
            $table->string('total_reviews')->nullable();
            $table->tinyInteger('media_type')->default('1')->comment = '1 = File';
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->string('extension')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('thumb_path')->nullable();
            $table->string('pdf_name')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('product_no')->nullable();
            $table->string('original_name')->nullable();
            $table->tinyInteger('status')->default('1')->comment = '0 InActive/1 Active';
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
        Schema::dropIfExists('papers');
    }
}
