<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSampleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('sample', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('enroll_id');
          $table->integer('sample_id');
          $table->integer('nikshay_id');
          $table->integer('user_id');
          $table->string('name');
          $table->date('receive_date');
          $table->string('sample_quality');
          $table->string('sample_type')->nullable();
          $table->string('test_reason');
          $table->integer('fu_month')->nullable();
          $table->string('is_accepted');
           $table->string('visual')->nullable();
          //$table->enum('is_accepted', ['0', '1']);
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
        Schema::dropIfExists('sample');
    }
}
