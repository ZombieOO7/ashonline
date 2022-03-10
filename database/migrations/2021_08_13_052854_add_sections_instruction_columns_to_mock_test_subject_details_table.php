<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSectionsInstructionColumnsToMockTestSubjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mock_test_subject_details', function (Blueprint $table) {
            if (!Schema::hasColumn('mock_test_subject_details', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('mock_test_subject_details', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('mock_test_subject_details', 'instruction_read_time')) {
                $table->string('instruction_read_time')->nullable();
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
        Schema::table('mock_test_subject_details', function (Blueprint $table) {
            if (Schema::hasColumn('mock_test_subject_details', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('mock_test_subject_details', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('mock_test_subject_details', 'instruction_read_time')) {
                $table->dropColumn('instruction_read_time');
            }
        });
    }
}
