<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResizeImagesColumnToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            if (!Schema::hasColumn('questions', 'resize_full_image')) {
                $table->text('resize_full_image')->nullable();
            }
            if (!Schema::hasColumn('questions', 'resize_question_image')) {
                $table->text('resize_question_image')->nullable();
            }
            if (!Schema::hasColumn('questions', 'resize_answer_image')) {
                $table->text('resize_answer_image')->nullable();
            }
            if (!Schema::hasColumn('questions', 'answer_type')) {
                $table->smallInteger('answer_type')->default('1')->comment='1=single, 2=multiple';
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
        Schema::table('questions', function (Blueprint $table) {
            //
        });
    }
}
