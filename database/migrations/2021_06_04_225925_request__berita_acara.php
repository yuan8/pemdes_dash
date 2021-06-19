<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RequestBeritaAcara extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tb_berita_acara', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('penanda_tangan');
            $table->integer('status')->default(0);
            $table->dateTime('date_jadwal')->nullable();
            $table->string('path_berita_acara')->nullable();
            $table->string('path_ttd')->nullable();
            $table->bigInteger('id_ms_table')->unsigned();
            $table->integer('kode_daerah');
            $table->integer('tahun');
            $table->bigInteger('id_user')->nullable();
            $table->bigInteger('id_user_updated')->nullable();
            $table->timestamps();

            $table->unique(['id_ms_table','tahun','kode_daerah']);
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
        Schema::dropIfExists('tb_berita_acara');

    }
}
