<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExamStyleColumnToCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms', function (Blueprint $table) {
            if (!Schema::hasColumn('cms', 'exam_style')) {
                $table->text('exam_style')->nullable();
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
        Schema::table('cms', function (Blueprint $table) {
            if (Schema::hasColumn('cms', 'exam_style')) {
                $table->dropColumn('exam_style');
            }
        });
    }
}
