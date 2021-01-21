<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateT2stLineLpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('t_2stlinelpa', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('enroll_id');
          $table->integer('sample_id');
          $table->integer('lpa_interpretation_id')->nullable();

          $table->integer('gyra')->nullable();
          $table->integer('wt18590')->nullable();
          $table->integer('wt28993')->nullable();
          $table->integer('wt39297')->nullable();
          $table->integer('mut1A90V')->nullable();
          $table->integer('mut2S91P')->nullable();
          $table->integer('mut3aD94A')->nullable();
          $table->integer('mut3bD94N')->nullable();
          $table->integer('mut3cD94G')->nullable();
          $table->integer('mut3dD94H')->nullable();
          $table->integer('gyrb')->nullable();
          $table->integer('wt1536541')->nullable();
          $table->integer('mut1N538D')->nullable();
          $table->integer('mut2E540V')->nullable();
          $table->integer('rrs')->nullable();
          $table->integer('wt1140102')->nullable();
          $table->integer('wt21484')->nullable();
          $table->integer('mut1A1401G')->nullable();
          $table->integer('mut2G1484T')->nullable();
          $table->integer('eis')->nullable();
          $table->integer('wt137')->nullable();
          $table->integer('wt2141210')->nullable();
          $table->integer('wt32')->nullable();
          $table->integer('mut1c14t')->nullable();
          

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
        Schema::dropIfExists('t_2stLineLpa');
    }
}
