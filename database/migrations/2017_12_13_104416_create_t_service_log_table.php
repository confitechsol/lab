<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTServiceLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_service_log', function (Blueprint $table) {
        $table->increments('id');
          $table->integer('enroll_id');
          $table->string('sample_id');
          $table->integer('service_id');
          $table->integer('status')->default(1);
          $table->integer('created_by');
          $table->integer('updated_by');
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
        Schema::dropIfExists('t_service_log');
    }
}
