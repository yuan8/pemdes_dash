<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SsoAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('sso_access', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->string('app');
            $table->string('email');
            $table->integer('pemda_id')->nullable();
            $table->string('token_sso');
            $table->string('pass')->nullable();
            $table->unique(['id_user','app']);
            $table->timestamps();

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
        Schema::dropIfExists('sso_access');

    }
}
