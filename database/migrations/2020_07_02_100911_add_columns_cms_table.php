<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms', function (Blueprint $table) {
            if (!Schema::hasColumn('cms', 'short_description')) {
                $table->text('short_description')->nullable();
            }
            if (!Schema::hasColumn('cms', 'type')) {
                $table->tinyInteger('type')->nullable()->default('1')->comment('1=general, 2=subject, 3=school');
            }
            if (!Schema::hasColumn('cms', 'school_id')) {
                $table->unsignedBigInteger('school_id')->nullable();
                $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade')->onUpdate('cascade');
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
        //
    }
}
