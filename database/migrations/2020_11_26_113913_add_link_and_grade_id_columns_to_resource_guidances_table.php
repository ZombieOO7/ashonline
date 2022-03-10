<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkAndGradeIdColumnsToResourceGuidancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_guidances', function (Blueprint $table) {
            if (!Schema::hasColumn('resource_guidances', 'link')) {
                $table->text('link')->nullable();
            }
            if (!Schema::hasColumn('resource_guidances', 'grade_id')) {
                $table->unsignedBigInteger('grade_id')->nullable();
                $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('resource_guidances', function (Blueprint $table) {
            if (Schema::hasColumn('resource_guidances', 'link')) {
                $table->dropColumn('link');
            }
            if (Schema::hasColumn('resource_guidances', 'grade_id')) {
                $table->dropForeign('resource_guidances_grade_id_foreign');
                $table->dropColumn('grade_id');
            }
        });
    }
}
