<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->bigInteger('paper_category_id')->unsigned()->nullable()->comment = 'PK of paper_categories';
            $table->foreign('paper_category_id')->references('id')->on('paper_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('status')->default('1')->comment = '0 Inactive/1 ctive';
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
        Schema::dropIfExists('exam_types');
    }
}
