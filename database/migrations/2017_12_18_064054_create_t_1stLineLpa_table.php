<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateT1stLineLpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_1stlinelpa', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('enroll_id');
          $table->integer('sample_id');
          $table->integer('lpa_interpretation_id')->nullable();

          $table->integer('RpoB')->nullable();
          $table->integer('wt1')->nullable();
          $table->integer('wt2')->nullable();
          $table->integer('wt3')->nullable();
          $table->integer('wt4')->nullable();
          $table->integer('wt5')->nullable();
          $table->integer('wt6')->nullable();
          $table->integer('wt7')->nullable();
          $table->integer('wt8')->nullable();
          $table->integer('mut1DS16V')->nullable();
          $table->integer('mut2aH526Y')->nullable();
          $table->integer('mut2bH526D')->nullable();
          $table->integer('mut3S531L')->nullable();
          $table->integer('katg')->nullable();
          $table->integer('wt1315')->nullable();
          $table->integer('mut1S315T1')->nullable();
          $table->integer('mut2S315T2')->nullable();
          $table->integer('inha')->nullable();
          $table->integer('wt1516')->nullable();
          $table->integer('wt28')->nullable();
          $table->integer('mut1C15T')->nullable();
          $table->integer('mut2A16G')->nullable();
          $table->integer('mut3aT8C')->nullable();
          $table->integer('mut3bT8A')->nullable();
          

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
        Schema::dropIfExists('t_1stLineLpa');
    }
}
