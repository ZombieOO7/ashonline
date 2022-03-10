<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCardDetailColumnsToParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parents', function (Blueprint $table) {
            if (!Schema::hasColumn('parents', 'card_number')) {
                $table->string('card_number')->nullable();
            }
            if (!Schema::hasColumn('parents', 'name_on_card')) {
                $table->string('name_on_card')->nullable();
            }
            if (!Schema::hasColumn('parents', 'expiry_date')) {
                $table->string('expiry_date')->nullable();
            }
            if (!Schema::hasColumn('parents', 'cvv')) {
                $table->string('cvv')->nullable();
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
        Schema::table('parents', function (Blueprint $table) {
            //
        });
    }
}
