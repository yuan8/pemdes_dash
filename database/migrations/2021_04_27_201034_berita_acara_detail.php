<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeritaAcaraDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('tb_berita_acara_holder', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_berita_acara')->unsigned();
            $table->bigInteger('id_user')->nullable();
            $table->timestamps();
            $table->unique(['id_berita_acara','id_user']);
            $table->index(['id_berita_acara','id_user']);


            $table->foreign('id_berita_acara')
                  ->references('id')->on('tb_berita_acara')
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
        Schema::dropIfExists('tb_berita_acara_holder');

    }
}
