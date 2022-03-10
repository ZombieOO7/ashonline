<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('extension')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('image_path')->nullable();
            $table->string('thumb_path')->nullable();
            $table->string('color_code')->nullable();
            $table->integer('position')->nullable();
            $table->text('product_content')->nullable();
            $table->tinyInteger('type')->default('1')->nullable()->comment = '1= Grade/2= Sats';
            $table->tinyInteger('status')->default('1')->comment = '0 Inactive/1 Active';
            $table->integer('sequence')->nullable();
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
        Schema::dropIfExists('paper_categories');
    }
}
