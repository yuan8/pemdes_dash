<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Jadwal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('tb_jadwal_pengisian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tahun');
            $table->bigInteger('kode_daerah');
            $table->integer('level');
            $table->dateTime('mulai');
            $table->dateTime('selesai');
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();

            $table->unique(['tahun','kode_daerah','level']);

        
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
        Schema::dropIfExists('tb_jadwal_pengisian');

    }
}
