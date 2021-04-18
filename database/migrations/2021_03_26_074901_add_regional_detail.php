<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegionalDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('master_regional_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_regional')->unsigned();
            $table->bigInteger('kode_daerah');
            $table->timestamps();
            $table->unique(['id_regional','kode_daerah']);

             $table->foreign('id_regional')
                  ->references('id')->on('master_regional')
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('master_regional_detail');

    }
}
