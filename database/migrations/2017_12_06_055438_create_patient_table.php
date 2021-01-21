<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nikshay id')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('tb')->nullable();
            $table->string('phi')->nullable();
            $table->string('adhar_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('house_no')->nullable();
            $table->string('street')->nullable();
            $table->string('ward')->nullable();
            $table->string('town/city/village')->nullable();
            $table->string('taluka')->nullable();
            $table->string('landmark')->nullable();
            $table->string('landmark_state')->nullable();
            $table->string('landmark_district')->nullable();
            $table->string('pincode')->nullable();
            $table->string('area')->nullable();
            $table->string('marital_state')->nullable();
            $table->string('occupation')->nullable();
            $table->string('socioeconomy_status')->nullable();
            $table->string('cp_name')->nullable();
            $table->string('cp_phn_no')->nullable();
            $table->string('cp_address')->nullable();
            $table->string('key_population')->nullable();
            $table->string('hiv_test')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('patient');
    }
}
