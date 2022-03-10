<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutionParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tution_parents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->comment = 'encrypted id';
            $table->string('first_name')->nullable()->comment('First Name');
            $table->string('last_name')->nullable()->comment('Last Name');
            $table->string('middle_name')->nullable()->comment('Middle Name');
            $table->string('full_name')->nullable()->comment('Full Name');
            $table->string('email')->unique()->nullable()->comment('Student Email Address');
            $table->string('password')->unique()->nullable();
            $table->string('mobile')->unique()->nullable()->comment('mobile_number');
            $table->string('dob')->nullable()->comment('Date of Birth');
            $table->string('gender')->nullable()->comment('Male or Female');
            $table->string('profile_pic')->nullable()->comment('Profile Picture');
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');
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
        Schema::dropIfExists('tution_parents');
    }
}
