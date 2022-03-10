<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('resource_category_id')->nullable();
            $table->foreign('resource_category_id')->references('id')->on('resource_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('question_original_name')->nullable()->comment('File original name');
            $table->string('question_stored_name')->nullable()->comment('File stored name');
            $table->string('answer_original_name')->nullable()->comment('File original name');
            $table->string('answer_stored_name')->nullable()->comment('File stored name');
            $table->tinyInteger('status')->default('1')->comment = '0 Inactive/1 active';
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
        Schema::dropIfExists('resources');
    }
}
