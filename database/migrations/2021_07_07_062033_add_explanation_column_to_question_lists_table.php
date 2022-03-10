<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExplanationColumnToQuestionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_lists', function (Blueprint $table) {
            if(!Schema::hasColumn('question_lists', 'explanation')) {
                $table->text('explanation')->nullable();
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
        Schema::table('question_lists', function (Blueprint $table) {
            if(Schema::hasColumn('question_lists', 'explanation')) {
                $table->dropColumn('explanation');
            }
        });
    }
}
