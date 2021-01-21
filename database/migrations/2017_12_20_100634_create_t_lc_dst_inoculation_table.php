<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTLcDstInoculationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('t_lc_dst_inoculation', function (Blueprint $table) {
       $table->increments('id');
        $table->integer('enroll_id');
        $table->integer('sample_id');
        $table->string('mgit_seq_id');
        $table->string('dst_c_id1');
        $table->string('dst_c_id2');
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
        Schema::dropIfExists('t_lc_dst_inoculation');
    }
}
