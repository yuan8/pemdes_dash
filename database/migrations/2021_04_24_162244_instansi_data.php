<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InstansiData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        Schema::create('tb_data_instansi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_data')->unsigned();
            $table->bigInteger('id_instansi')->unsigned();
            $table->bigInteger('id_user');
            $table->bigInteger('id_user_update');
            $table->unique(['id_data','id_instansi']);
            $table->foreign('id_instansi')
                  ->references('id')->on('master_instansi')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_data')
                  ->references('id')->on('tb_data')
                  ->onDelete('cascade')->onUpdate('cascade');

        });


    }

    
    public function down()
    {
        Schema::dropIfExists('tb_data_instansi');
    }
}
