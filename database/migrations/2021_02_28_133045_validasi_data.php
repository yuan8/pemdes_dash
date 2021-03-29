<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ValidasiData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('validasi_confirm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_desa',10)->index();
            $table->string('table',165);
            $table->integer('tahun');
            $table->dateTime('tanggal_validasi');
            $table->bigInteger('id_user')->unsigned();
            $table->text('keterangan')->nullabe();

            $table->unique(['kode_desa','table','tahun']);

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
        Schema::dropIfExists('validasi_confirm');

    }
}
