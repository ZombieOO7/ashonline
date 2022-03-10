<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->comment = 'encrypted id';
            $table->string('first_name')->nullable()->comment('First Name');
            $table->string('last_name')->nullable()->comment('Last Name');
            $table->string('middle_name')->nullable()->comment('Middle Name');
            $table->string('full_name')->nullable()->comment('Full Name');
            $table->datetime('dob')->nullable()->comment('Date of Birth');
            $table->string('gender')->nullable()->comment('Male or Female');
            $table->string('email')->nullable()->comment('Student Email Address');
            $table->string('password')->nullable();
            $table->string('address')->nullable()->comment('Proper Address');
            $table->string('city')->nullable()->comment('City');
            $table->string('zip_code')->nullable()->comment('6 digits');
            $table->string('mobile')->nullable()->comment('mobile_number');
            $table->string('profile_pic')->nullable()->comment('Profile Picture');
            $table->string('region')->nullable();
            $table->string('county')->nullable();
            $table->string('council')->nullable();
            $table->string('student_no')->nullable()->comment('Start from 1001');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('parents')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id')->references('id')->on('schools')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('active')->default('1')->nullable()->comment('0 for inactive, 1 for active');
            $table->tinyInteger('project_type')->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
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
        Schema::dropIfExists('students');
    }
}
