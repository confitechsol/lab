<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCultureInoculationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('t_culture_inoculation', function (Blueprint $table) {
       $table->increments('id');
        $table->integer('enroll_id');
        $table->string('sample_id');
        $table->string('mgit_id');
        $table->string('tube_id_lj')->nullable();
        $table->string('tube_id_lc')->nullable();
        $table->string('inoculation_date');
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
        Schema::dropIfExists('t_culture_inoculation');
    }
}
