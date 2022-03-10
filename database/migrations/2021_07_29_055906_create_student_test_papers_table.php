<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTestPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_test_papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('mock_test_paper_id')->nullable()->comment='pk of mock_test_papers';
            $table->foreign('mock_test_paper_id')->references('id')->on('mock_test_papers')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('student_test_id')->nullable()->comment='pk of student_tests';
            $table->foreign('student_test_id')->references('id')->on('student_tests')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('student_id')->nullable()->comment='pk of students';
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->double('questions')->nullable()->default(0);
            $table->double('attempted')->nullable()->default(0);
            $table->double('unanswered')->nullable()->default(0);
            $table->double('correctly_answered')->nullable()->default(0);
            $table->double('obtained_marks')->nullable()->default(0);
            $table->double('overall_result')->nullable()->default(0);
            $table->double('total_marks')->nullable()->default(0);
            $table->smallInteger('is_completed')->default(0)->comment='0=No, 1=Yes';
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
        Schema::dropIfExists('student_test_papers');
    }
}
