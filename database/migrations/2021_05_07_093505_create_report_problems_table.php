<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_problems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('mock_test_id')->nullable()->comment='pk of mock_tests table';
            $table->foreign('mock_test_id')->references('id')->on('mock_tests')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('question_list_id')->nullable()->comment='pk of questions_lists table';
            $table->foreign('question_list_id')->references('id')->on('question_lists')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('student_id')->nullable()->comment='pk of students table';
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('test_assessment_id')->nullable()->comment='pk of test_assessments table';
            $table->foreign('test_assessment_id')->references('id')->on('test_assessments')->onDelete('cascade')->onUpdate('cascade');
            $table->text('description')->nullable();
            $table->smallInteger('project_type')->nullable()->default('0')->comment = '0 = paper, 1 = mock , 2 = practice & 3 = topics';
            $table->smallInteger('status')->default(0)->comment='0=pending, 1=Approve, 2=Reject';
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
        Schema::dropIfExists('report_problems');
    }
}
