<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbnaatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_cbnaat', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('enroll_id');
          $table->string('sample_id');
          $table->text('result_MTB');
          $table->integer('error')->nullable();
          $table->text('result_RIF');
          $table->text('next_step');
          $table->string('test_date');
          $table->integer('status')->default(1);
          $table->integer('created_by');
          $table->integer('updated_by');

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
        Schema::dropIfExists('t_cbnaat');
    }
}
