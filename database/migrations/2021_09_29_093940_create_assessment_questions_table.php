<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable()->unique();
            $table->unsignedBigInteger('subject_id')->nullable()->comment('pk of subjects table');
            $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('topic_id')->nullable()->comment('pk of topics table');
            $table->foreign('topic_id')->references('id')->on('topics')->onUpdate('cascade')->onDelete('cascade');
            $table->smallInteger('type')->default('1')->comment('1 = MCQ, 2 = Comprehensive, 3 = Cloze');
            $table->smallInteger('status')->default('1')->comment('0 for inactive, 1 for active');
            $table->smallInteger('project_type')->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->smallInteger('is_passage')->default('0')->comment('0 = No, 1 = Yes');
            $table->smallInteger('is_entry_type')->default('1')->comment('1 = Excel, 2 = Manually');
            $table->smallInteger('question_type')->default('1')->comment('1=MCQ, 2=Standard');
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
        Schema::dropIfExists('assessment_questions');
    }
}
