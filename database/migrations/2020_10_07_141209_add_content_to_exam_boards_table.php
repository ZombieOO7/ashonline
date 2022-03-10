<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContentToExamBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_boards', function (Blueprint $table) {
            if(!Schema::hasColumn('exam_boards','content')){
                $table->text('content')->nullable();
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
        Schema::table('exam_boards', function (Blueprint $table) {
            if(Schema::hasColumn('exam_boards','content')){
                $table->dropColumn('content');
            }
        });
    }
}
