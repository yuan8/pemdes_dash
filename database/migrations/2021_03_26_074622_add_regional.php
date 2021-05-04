<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('master_regional', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('deskripsi_min')->nulable();
            $table->mediumText('deskripsi')->nulable();
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
        //
        Schema::dropIfExists('master_regional');
        
    }
}
