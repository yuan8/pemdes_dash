<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Settings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        //
         Schema::create('master_setting', function (Blueprint $table) {

            $table->string('flag')->index()->unique();
            $table->mediumText('value')->nullable();
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
        Schema::dropIfExists('master_setting');

    }
}
