<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicroscopyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('microscopy', function (Blueprint $table) {
        $table->increments('id');
        $table->string('sample_id');
        $table->string('result');
        $table->integer('status')->default(1);
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
        Schema::dropIfExists('microscopy');
    }
}
