<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class TahunAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tahun_access', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tahun')->unique();
            $table->timestamps();
        });

        DB::table('tahun_access')->insert(['tahun'=>date('Y')]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('tahun_access');

    }
}
