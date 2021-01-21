<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_cat')->nullable();
            $table->string('name')->nullable();
            $table->string('tool')->nullable();
            $table->string('status')->nullable();
            $table->string('supplier')->nullable();
            $table->string('make')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('model_no')->nullable();
            $table->string('date_installation')->nullable();
            $table->string('location')->nullable();
            $table->string('provider')->nullable();
            $table->string('waranty_status')->nullable();
            $table->string('date_last_maintain')->nullable();
            $table->string('maintainance_report')->nullable();
            $table->string('due_date')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('responsible_person')->nullable();
            $table->string('date_decommission')->nullable();
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
        Schema::dropIfExists('m_equipment');
    }
}
