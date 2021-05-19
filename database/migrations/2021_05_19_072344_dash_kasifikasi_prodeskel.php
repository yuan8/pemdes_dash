<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DashKasifikasiProdeskel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('dash_klasifikasi_prodeskel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kode_desa');
            $table->integer('tahun');
            $table->integer('status_validasi')->default(0);
            $table->dateTime('validasi_date')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('ketegori')->nullable();
            $table->integer('tipologi')->nullable();
            $table->unique(['kode_desa','tahun']);

        });

         Schema::create('dash_klasifikasi_epdeskel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kode_desa');
            $table->integer('tahun');
            $table->integer('status_validasi')->default(0);
            $table->dateTime('validasi_date')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('ketegori')->nullable();
            $table->integer('tipologi')->nullable();
            $table->unique(['kode_desa','tahun']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dash_klasifikasi_prodeskel');
        Schema::dropIfExists('dash_klasifikasi_epdeskel');
        

    }
}
