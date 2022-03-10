<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentExamBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_exam_boards', function (Blueprint $table) {
            if (!Schema::hasColumn('student_exam_boards', 'student_id')) {
                $table->unsignedBigInteger('student_id')->nullable();
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
            }
            if (!Schema::hasColumn('student_exam_boards', 'exam_board_id')) {
                $table->unsignedBigInteger('exam_board_id')->nullable();
                $table->foreign('exam_board_id')->references('id')->on('exam_boards')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('student_exam_boards', function (Blueprint $table) {
            if (Schema::hasColumn('student_exam_boards', 'student_id')) {
                $table->dropForeign('student_exam_boards_student_id_foreign');
                $table->dropColumn('student_id');
            }
            if (Schema::hasColumn('student_exam_boards', 'exam_board_id')) {
                $table->dropForeign('student_exam_boards_exam_board_id_foreign');
                $table->dropColumn('exam_board_id');
            }
        });
    }
}
