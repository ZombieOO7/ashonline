<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaperShowToColumnToPastPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('past_papers', function (Blueprint $table) {
            if(!Schema::hasColumn('past_papers','paper_show_to')){
                $table->smallInteger('paper_show_to')->nullable()
                ->default(1)->comment('1 for All Member,2 for Premium Member');
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
        Schema::table('past_papers', function (Blueprint $table) {
            if(Schema::hasColumn('past_papers','paper_show_to')){
                $table->dropColumn('past_papers');
            }
        });
    }
}
