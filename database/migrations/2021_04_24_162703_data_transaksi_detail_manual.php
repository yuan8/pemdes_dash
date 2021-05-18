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
            $table->bigInteger('id_data')->unsigned();
            $table->string('path_file');
            $table->string('extension');
            $table->double('size')->nullable();
            $table->foreign('id_data')
                  ->references('id')->on('tb_data')
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
        Schema::dropIfExists('tb_data_detail_info_graph');

    }
}
