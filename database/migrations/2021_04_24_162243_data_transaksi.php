<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('tb_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('type');
            $table->boolean('auth')->default(0);
            $table->integer('tahun')->nullable();
            $table->integer('kode_daerah')->nullable();
            $table->text('deskripsi_min')->nullable();
            $table->mediumText('deskripsi')->nullable();
            $table->text('keywords')->nullable();
            $table->bigInteger('id_user');
            $table->bigInteger('id_user_update');
            $table->bigInteger('status');
            $table->dateTime('publish_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_data');

    }
}