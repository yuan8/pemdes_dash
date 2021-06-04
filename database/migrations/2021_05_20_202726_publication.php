<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Publication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('tb_publikasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->default(0);
            $table->dateTime('publish_date')->nullable();
            $table->bigInteger('kode_daerah')->nullable();
            $table->bigInteger('id_instansi')->nullable()->unsigned();
            $table->bigInteger('id_category')->nullable()->unsigned();
            $table->bigInteger('id_user')->nullable();
            $table->bigInteger('id_user_updated')->nullable();
            $table->string('title');
            $table->string('file_path')->nullable();
            $table->double('size')->nullable();
            $table->string('file_path_per_page')->nullable();
            $table->integer('max_page')->nullable();
            $table->text('keywords')->nullable();
            $table->mediumText('description')->nullable();
            $table->text('description_min')->nullable();
            $table->timestamps();

            $table->foreign('id_category')
                  ->references('id')->on('tb_category')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_instansi')
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
        Schema::dropIfExists('tb_publikasi');

    }
}
