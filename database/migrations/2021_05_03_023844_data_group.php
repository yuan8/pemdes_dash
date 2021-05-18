<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('tb_data_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_data')->unsigned();
            $table->bigInteger('id_category')->unsigned();

            $table->foreign('id_category')
                  ->references('id')->on('master_category')
                  ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('tb_data_group');
        
    }
}