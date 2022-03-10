<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->comment('encrypted user id');
            $table->unsignedBigInteger('question_list_id')->nullable();
            $table->foreign('question_list_id')->references('id')->on('question_lists')->onUpdate('cascade')->onDelete('cascade');
            $table->text('answer')->nullable();
            $table->tinyInteger('is_correct')->default('1')->comment('0 for in correct, 1 for correct');
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
        Schema::dropIfExists('answers');
    }
}
