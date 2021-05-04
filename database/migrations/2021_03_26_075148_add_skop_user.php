<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkopUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('users_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_regional')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();
            
            $table->unique(['id_regional','id_user']);
             $table->foreign('id_regional')
                  ->references('id')->on('master_regional')
                  ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('users_group');

    }
}
