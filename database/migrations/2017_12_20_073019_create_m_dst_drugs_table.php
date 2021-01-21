<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMDstDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('m_dst_drugs', function (Blueprint $table) {
       $table->increments('id');
        $table->string('name');
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
        Schema::dropIfExists('m_dst_drugs');
    }
}
