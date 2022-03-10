<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->comment = 'encrypted id';
            $table->string('school_name')->comment('School Name');
            $table->unsignedBigInteger('categories')->comment('PK of Exam Board')->nullable();
            $table->foreign('categories')->references('id')->on('exam_boards')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('project_type')->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->tinyInteger('is_multiple')->default(0)->comment = '0 = No, 1 = Yes';
            $table->tinyInteger('active')->default(0)->comment = '0 - Inactive, 1 - Active';
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
