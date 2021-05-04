<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataTransaksiDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('tb_data_detail_map', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_data')->unsigned();            
            $table->bigInteger('id_map')->unsigned();
            $table->unique(['id_data','id_map']);

            $table->foreign('id_data')
                  ->references('id')->on('tb_data')
                  ->onDelete('cascade')->onUpdate('cascade');

             $table->foreign('id_map')
                  ->references('id')->on('master_table_map')
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
        Schema::dropIfExists('tb_data_detail_map');

    }
}
