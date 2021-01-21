<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_configuration', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lab_name')->nullable();
            $table->string('lab_code')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('details')->nullable();
            $table->string('logo')->nullable();
            $table->string('micro_name')->nullable();
            $table->string('micro_email')->nullable();
            $table->string('micro_number')->nullable();
            $table->string('barcode_offset')->nullable();
            $table->string('sink_schedule')->nullable();
            $table->string('sink_user')->nullable();
            $table->integer('sink_user_id')->nullable();
            $table->string('sink_password')->nullable();
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
       Schema::dropIfExists('m_configuration');
    }
}
