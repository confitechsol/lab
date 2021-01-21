<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMHrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_hr', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('qualification')->nullable();
            $table->string('mode')->nullable();
            $table->string('date_joining')->nullable();
            $table->string('date_reliving')->nullable();
            $table->string('health_check')->nullable();
            $table->string('vaccination')->nullable();
            $table->string('training_subject')->nullable();
            $table->string('training_date')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
         Schema::dropIfExists('m_hr');
    }
}
