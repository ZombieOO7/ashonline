<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPassageColumnToTestAssessmentSubjectInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_assessment_subject_infos', function (Blueprint $table) {
            if(!Schema::hasColumn('test_assessment_subject_infos','passage')){
                $table->string('passage')->nullable();
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
        Schema::table('test_assessment_subject_infos', function (Blueprint $table) {
            //
        });
    }
}
