<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentQuestionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_question_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->comment('encrypted user id');
            $table->string('question_no')->nullable();
            $table->unsignedBigInteger('question_id')->nullable()->comment('pk of questions table');
            $table->foreign('question_id')->references('id')->on('practice_questions')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('question')->nullable();
            $table->text('instruction')->nullable();
            $table->double('marks')->nullable();
            $table->string('image')->nullable();
            $table->text('explanation')->nullable();
            $table->string('question_image')->nullable();
            $table->string('answer_image')->nullable();
            $table->unsignedBigInteger('topic_id')->nullable()->comment('pk of topics table');
            $table->foreign('topic_id')->references('id')->on('topics')->onUpdate('cascade')->onDelete('cascade');
            $table->smallInteger('answer_type')->comment('1=single, 2=multiple')->default(0)->nullable();
            $table->double('total_ans')->default('0');
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
        Schema::dropIfExists('assessment_question_lists');
    }
}
