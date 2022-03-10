<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->comment = 'encrypted id';
            $table->string('first_name')->nullable()->comment('First Name');
            $table->string('last_name')->nullable()->comment('Last Name');
            $table->string('middle_name')->nullable()->comment('Middle Name');
            $table->string('full_name')->nullable()->comment('Full Name');
            $table->string('dob')->nullable()->comment('Date of Birth');
            $table->string('gender')->nullable()->comment('Male or Female');
            $table->string('email')->nullable()->comment('Student Email Address');
            $table->string('password')->nullable();
            $table->string('address')->nullable()->comment('Proper Address');
            $table->string('city')->nullable()->comment('City');
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable()->comment('6 digits');
            $table->string('mobile')->nullable()->comment('mobile_number');
            $table->string('profile_pic')->nullable()->comment('Profile Picture');
            $table->tinyInteger('is_tuition_parent')->default(0)->comment('0 = False, 1 = True');
            $table->dateTime('email_verified_at')->nullable();
            $table->string('remember_token')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->tinyInteger('project_type')->default('0')->comment = '0 = paper, 1 = mock & 2 = practice';
            $table->tinyInteger('is_verify')->default(0)->comment('0 = No, 1 = yes');
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
        Schema::dropIfExists('parents');
    }
}
