<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MasterDaerah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('master_provinsi', function (Blueprint $table) {
            $table->bigIncrements('kdprovinsi');
            $table->string('nmprovinsi');

        });

        Schema::create('master_kabkota', function (Blueprint $table) {
            $table->bigIncrements('kdkabkota');
            $table->integer('id_parent')->nullable()->unsigned();
            $table->string('nmkabkota');
            $table->string('nmprovinsi',100);

        });

        Schema::create('master_kecamatan', function (Blueprint $table) {
            $table->bigIncrements('kdkecamatan');
            $table->integer('id_parent')->nullable()->unsigned();
            $table->string('nmkecamatan');
            $table->string('nmkabkota',100);
            $table->string('nmprovinsi',100);


        });

       
        Schema::create('master_desa', function (Blueprint $table) {
            $table->bigIncrements('kddesa');
            $table->integer('id_parent')->nullable()->unsigned();
            $table->string('nmdesa');
            $table->string('stapem')->index();
            $table->string('nmkecamatan',100);
            $table->string('nmkabkota',100);
            $table->string('nmprovinsi',100);

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
        Schema::dropIfExists('master_desa');
        
        Schema::dropIfExists('master_kecamatan');
        
        Schema::dropIfExists('master_kabkota');
        
        Schema::dropIfExists('master_provinsi');


    }
}
