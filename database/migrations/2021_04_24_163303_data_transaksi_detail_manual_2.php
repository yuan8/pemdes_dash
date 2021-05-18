<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataTransaksiDetailManual2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('tb_data_detail_table', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_data')->unique()->unsigned();
            $table->string('path_file');
            $table->string('path_file_render');
            $table->string('extension');
            $table->double('size')->nullable();
             $table->foreign('id_data')
                  ->references('id')->on('tb_data')
                  ->onDelete('cascade')->onUpdate('cascade');

        });

        Schema::create('tb_data_detail_visualisasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_data')->unique()->unsigned();
            $table->string('path_file');
            $table->string('path_file_render');
            $table->string('extension');
            $table->boolean('inheritance')->default(true);
            $table->integer('level_start')->default(2);
            $table->integer('level_stop')->default(10);
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
        Schema::dropIfExists('tb_data_detail_table');
        Schema::dropIfExists('tb_data_detail_visualisasi');
        
        

    }   
}
