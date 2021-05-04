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
         Schema::create('master_jadwal_ver_val', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kode_daerah');
            $table->integer('level');
            $table->integer('tahun');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->bigInteger('id_user')->nullable();
            $table->timestamps();


            $table->unique(['kode_daerah','level']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_jadwal_ver_val');
    }
}
