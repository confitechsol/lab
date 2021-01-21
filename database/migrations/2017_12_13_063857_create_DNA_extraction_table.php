<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDNAExtractionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('t_dnaextraction', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('enroll_id');
        $table->integer('sample_id');
        $table->integer('created_by');
        $table->integer('updated_by');
        $table->integer('status')->default(1);
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
        Schema::dropIfExists('t_dnaextraction');
    }
}
