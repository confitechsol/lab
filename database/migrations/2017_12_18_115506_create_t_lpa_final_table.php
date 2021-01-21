<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTLpaFinalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_lpa_final', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('enroll_id');
          $table->integer('sample_id');
          $table->integer('lpa_interpretation_id')->nullable();
          $table->string('type')->nullable();

          $table->integer('mtb_result')->nullable();
          $table->string('rif')->nullable();
          $table->string('inh')->nullable();
          $table->string('quinolone')->nullable();
          $table->string('slid')->nullable();
          

          $table->string('test_date');
          $table->string('report_date');
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
        Schema::dropIfExists('t_lpa_final');
    }
}
