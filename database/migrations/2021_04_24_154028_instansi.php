<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Instansi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('master_instansi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type');
            $table->string('image_path')->nullable();            
            $table->bigInteger('parent_instansi')->nullable()->unsigned();
            $table->bigInteger('kode_daerah')->nullable();
            $table->text('tags')->nullable();
            $table->text('keywords')->nullable();
            $table->text('deskripsi_min')->nullable();
            $table->mediumText('deskripsi')->nullable();
            $table->bigInteger('id_user')->nullable();
            $table->bigInteger('id_user_update')->nullable();
            $table->timestamps();

            $table->unique(['name','kode_daerah']);            
            
            $table->foreign('parent_instansi')
                  ->references('id')->on('master_instansi')
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
        Schema::dropIfExists('master_instansi');

    }
}
