<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDstDrugsTrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('t_dst_drugs_tr', function (Blueprint $table) {
       $table->increments('id');
        $table->integer('enroll_id');
        $table->integer('sample_id');
        $table->string('drug_ids');
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
        Schema::dropIfExists('t_dst_drugs_tr');
    }
}
