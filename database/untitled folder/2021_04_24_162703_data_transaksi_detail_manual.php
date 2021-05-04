<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataTransaksiDetailManual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('tb_data_detail_info_graph', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigIncrements('id_data')->unsigned();
            $table->string('path_file');
            $table->string('extension');
            $table->double('size')->nullable();
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
        Schema::dropIfExists('tb_data_detail_info_graph');

    }
}
