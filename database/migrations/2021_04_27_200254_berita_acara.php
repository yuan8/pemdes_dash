<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeritaAcara extends Migration
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
            $table->bigInteger('kode_daerah');
            $table->integer('tahun');
            $table->bigInteger('id_table_map')->unsigned();
            $table->string('path_berita_acara')->nullable();
            $table->integer('status')->default(0);
            $table->bigInteger('id_user')->nullable();
            $table->timestamps();
            $table->unique(['kode_daerah','tahun','id_table_map']);
            $table->index(['kode_daerah','tahun','id_table_map']);


            $table->foreign('id_table_map')
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
        Schema::dropIfExists('tb_berita_acara');
    }
}
