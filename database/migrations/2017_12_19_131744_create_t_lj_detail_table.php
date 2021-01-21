<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTLjDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('t_lj_detail', function (Blueprint $table) {
       $table->increments('id');
        $table->integer('enroll_id');
        $table->integer('sample_id');
        $table->string('test_id');
        $table->string('culture_smear');
        $table->string('final_result');
        $table->string('lj_result_date');
        $table->string('result_week');
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
        Schema::dropIfExists('t_lj_detail');
    }
}
