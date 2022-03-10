<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToParentAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parent_addresses', function (Blueprint $table) {
            $table->text('address2')->nullable();
            $table->tinyInteger('default')->default('0')->nullable()->comment('0 for Not Default, 1 for Default;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parent_addresses', function (Blueprint $table) {
            $table->dropColumn(['address2','default']);
        });
    }
}
