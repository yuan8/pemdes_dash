<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotifikasiWa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('tb_notifikasi_wa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_table_map')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('kode_daerah');
            $table->bigInteger('kode_daerah_trigger')->nullable();
            $table->double('valid')->default(0);
            $table->double('ver_2')->default(0);
            $table->double('ver_4')->default(0);
            $table->double('ver_6')->default(0);
            $table->double('ver_10')->default(0);
            $table->double('unhandle')->default(0);
            $table->double('desa_terdata')->default(0);
            $table->double('desa_tidak_terdata')->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->index(['id_table_map','id_user','kode_daerah']);
            $table->index(['id_table_map','kode_daerah']);
            $table->index(['id_user']);



            $table->unique(['id_table_map','id_user','kode_daerah']);

            $table->foreign('id_user')
                  ->references('id')->on('users')
                  ->onDelete('cascade')->onUpdate('cascade');

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
        //
        Schema::dropIfExists('tb_notifikasi_wa');

    }
}
