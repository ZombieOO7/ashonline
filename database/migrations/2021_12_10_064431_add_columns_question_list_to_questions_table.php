<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsQuestionListToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            if(!Schema::hasColumn('questions','question_no')){
                $table->string('question_no')->nullable();
            }
            if(!Schema::hasColumn('questions','instruction')){
                $table->text('instruction')->nullable();
            }
            if(!Schema::hasColumn('questions','question')){
                $table->string('question')->nullable();
            }
            if(!Schema::hasColumn('questions','image')){
                $table->string('image')->nullable();
            }
            if(!Schema::hasColumn('questions','question_image')){
                $table->string('question_image')->nullable();
            }
            if(!Schema::hasColumn('questions','answer_image')){
                $table->string('answer_image')->nullable();
            }
            if(!Schema::hasColumn('questions','explanation')){
                $table->text('explanation')->nullable();
            }
            if(!Schema::hasColumn('questions','marks')){
                $table->double('marks')->default(0)->nullable();
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
