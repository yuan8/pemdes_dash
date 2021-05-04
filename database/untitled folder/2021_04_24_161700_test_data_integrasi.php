<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TestDataIntegrasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('testing_data_integrasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kode_desa')->unique();
            $table->integer('tahun');
            $table->integer('status_validasi')->default(0);
            $table->dateTime('validasi_date')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('data_sepedah_motor')->nullable();
            $table->integer('data_mobil')->nullable();
            $table->string('data_bengkel_mobil')->nullable();
            $table->string('data_bengkel_motor')->nullable();

        });

        Schema::connection('mysql')->create('testing_data_integrasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kode_desa')->unique();
            $table->integer('tahun');
            $table->integer('status_validasi')->default(0);
            $table->dateTime('validasi_date')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('data_sepedah_motor')->nullable();
            $table->integer('data_mobil')->nullable();
            $table->string('data_bengkel_mobil')->nullable();
            $table->string('data_bengkel_motor')->nullable();

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
        Schema::dropIfExists('testing_data_integrasi');
        Schema::connection('mysql')->dropIfExists('testing_data_integrasi');


    }
}
