<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InstansiData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        Schema::create('data_instansi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_data')->unsigned();
            $table->bigInteger('id_instasi');
            $table->bigInteger('id_user');
            $table->bigInteger('id_user_update');
            
            $table->unique(['id_data','id_instasi']);

        });


    }

    
    public function down()
    {
        Schema::dropIfExists('data_instansi');
    }
}
