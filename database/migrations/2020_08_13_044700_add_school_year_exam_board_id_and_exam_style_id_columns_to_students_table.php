<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolYearExamBoardIdAndExamStyleIdColumnsToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'school_year')) {
                $table->string('school_year')->nullable();
            }
            if (!Schema::hasColumn('students', 'exam_board_id')) {
                $table->unsignedBigInteger('exam_board_id')->nullable();
                $table->foreign('exam_board_id')->references('id')
                ->on('exam_boards')->onDelete('cascade')->onUpdate('cascade');
            }
            if (!Schema::hasColumn('students', 'exam_style_id')) {
                $table->tinyInteger('exam_style_id')->nullable()->comment = '1 = MCQ, 2 = Standard';
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
}
