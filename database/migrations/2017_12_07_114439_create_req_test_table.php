<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReqTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('req_test', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('enroll_id');
          $table->integer('facility_id');
          $table->integer('facility_type');
          $table->integer('req_test_type');
          $table->string('ho_anti_tb')->nullable();
          $table->string('predmnnt_symptoms')->nullable();
          $table->string('duration')->nullable();
          $table->string('state')->nullable();
          $table->string('district')->nullable();
          $table->string('tbu')->nullable();
          $table->string('request_date')->nullable();
          $table->string('pmdt_tb_no')->nullable();
          $table->string('rntcp_reg_no')->nullable();
          $table->string('regimen')->nullable();
          $table->string('reason')->nullable();
          $table->string('type_of_prsmptv_drtb')->nullable();
          $table->string('prsmptv_xdr_tb')->nullable();
          $table->string('treatment')->nullable();
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
        Schema::dropIfExists('req_test');
    }
}
