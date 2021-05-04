<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('master_view_method', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_ms_table')->unsigned();
            $table->string('type');
            $table->integer('level');
          
            $table->integer('row');
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id')->on('users')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_ms_table')
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
        Schema::dropIfExists('master_view_method');

    }
}
