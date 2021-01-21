<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDecontaminationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('t_decontamination', function (Blueprint $table) {
         $table->increments('id');
          $table->integer('enroll_id');
          $table->string('sample_id');
          $table->text('sent_for');
          $table->text('other')->nullable();
          $table->string('test_date');
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
        Schema::dropIfExists('t_decontamination');
    }
}
