<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApplyExtraChargesColumnToParentSubscriptionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parent_subscription_infos', function (Blueprint $table) {
            if (!Schema::hasColumn('parent_subscription_infos', 'extra_charges')) {
                $table->smallInteger('extra_charges')->default(0)->comment='0=No, 1=Yes';
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
            if (Schema::hasColumn('parent_subscription_infos', 'extra_charges')) {
                $table->dropColumn('extra_charges');
            }
        });
    }
}
