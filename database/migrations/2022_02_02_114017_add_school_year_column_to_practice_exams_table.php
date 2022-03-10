<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolYearColumnToPracticeExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_exams', function (Blueprint $table) {
            if (!Schema::hasColumn('practice_exams', 'school_year')) {
                $table->smallInteger('school_year')->nullable();
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
        Schema::table('practice_exams', function (Blueprint $table) {
            if (Schema::hasColumn('practice_exams', 'school_year')) {
                $table->dropColumn('school_year');
            }
        });
    }
}
