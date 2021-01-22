<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('data_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_data')->unsigned();
            $table->bigInteger('id_category')->unsigned();

            $table->foreign('id_category')
                  ->references('id')->on('category')
                  ->onDelete('cascade')->onUpdate('cascade');

             $table->foreign('id_data')
                  ->references('id')->on('data')
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
        Schema::dropIfExists('data_group');
        
    }
}
