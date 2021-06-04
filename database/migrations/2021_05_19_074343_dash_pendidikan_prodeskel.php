<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DashPendidikanProdeskel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('dash_pendidikan_prodeskel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kode_desa');
            $table->integer('tahun');
            $table->integer('status_validasi')->default(0);
            $table->dateTime('validasi_date')->nullable();
            $table->dateTime('updated_at')->nullable();

            // data

            $table->integer('tidak_sekolah')->nullable();
            $table->integer('sd')->nullable();
            $table->integer('smp')->nullable();
            $table->integer('sma')->nullable();
            $table->integer('pt')->nullable();
            $table->integer('jumlah_kk')->nullable();
            $table->integer('jumlah_ak')->nullable();





            // index
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
        //
        Schema::dropIfExists('dash_pendidikan_prodeskel');
        
    }
}
