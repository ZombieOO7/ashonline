<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('content')->nullable();
            $table->string('short_desc')->nullable();
            $table->string('image_path')->nullable();
            $table->string('name')->nullable();
            $table->string('extenstion')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->comment='pk of admins';
            $table->unsignedBigInteger('blog_category_id')->nullable()->comment='pk of blog categories';
            $table->tinyInteger('status')->default('1')->comment = '0 Inactive/1 Active';
            $table->tinyInteger('project_type')->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
