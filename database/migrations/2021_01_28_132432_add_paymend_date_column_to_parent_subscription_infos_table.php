<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymendDateColumnToParentSubscriptionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parent_subscription_infos', function (Blueprint $table) {
            if (!Schema::hasColumn('parent_subscription_infos', 'payment_date')) {
                $table->dateTime('payment_date')->nullable();
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
        Schema::table('parent_subscription_infos', function (Blueprint $table) {
            if (Schema::hasColumn('parent_subscription_infos', 'payment_date')) {
                $table->dropColumn('payment_date');
            }
        });
    }
}
