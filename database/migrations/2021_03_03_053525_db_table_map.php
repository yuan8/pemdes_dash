<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DbTableMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('master_table_map', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('table');
            $table->boolean('edit_daerah')->default(true);
            $table->boolean('inheritance')->default(true);
            $table->integer('start_level')->default(2);
            $table->integer('stop_level')->default(10);
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();
            $table->foreign('id_user')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('master_table_map');

    }
}
