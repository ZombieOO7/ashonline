<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            if (!Schema::hasColumn('questions', 'correct_answer')) {
                $table->double('correct_answer')->nullable()->default(0);
            }
            if (!Schema::hasColumn('questions', 'incorrect_answer')) {
                $table->double('incorrect_answer')->nullable()->default(0);
            }
            if (!Schema::hasColumn('questions', 'no_of_students')) {
                $table->double('no_of_students')->nullable()->default(0);
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
