<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriptionEndDateColumnToParentAndParentSubscriptionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parents', function (Blueprint $table) {
            if (!Schema::hasColumn('parents', 'subscription_end_date')) {
                $table->date('subscription_end_date')->nullable();
            }
        });
        Schema::table('parent_subscription_infos', function (Blueprint $table) {
            if (!Schema::hasColumn('parent_subscription_infos', 'subscription_end_date')) {
                $table->date('subscription_end_date')->nullable();
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
        Schema::table('parent_and_parent_subscription_infos', function (Blueprint $table) {
            //
        });
    }
}
