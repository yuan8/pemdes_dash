<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DbRowEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
         Schema::create('master_column_map', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_ms_table')->unsigned();
            $table->string('name');
            $table->string('name_column');
            $table->string('aggregate_type')->default('NONE');
            $table->string('satuan');
            $table->boolean('auth');
            $table->boolean('dashboard');
            $table->boolean('validate');
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();
            $table->foreign('id_user')
                  ->references('id')->on('users')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_ms_table')
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
        Schema::dropIfExists('master_column_map');

    }
}
