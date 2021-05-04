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
            $table->bigIncrements('id_data')->unsigned();            
            $table->bigIncrements('id_map')->unsigned();
            $table->unique(['id_data','id_map']);
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
