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
         Schema::create('publications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('type');
            $table->string('cover_img')->nullable();
            $table->boolean('auth')->default(false);
            $table->string('extension')->nullable();
            $table->float('size')->default(0);
            $table->string('document_path')->nullable();
            $table->integer('year')->nullable();
            $table->text('tags')->nullable();
            $table->text('keywords')->nullable();
            $table->bigInteger('organization_id')->unsigned()->nullable();
            $table->mediumText('content')->nullable();
            $table->text('content_min')->nullable();
            $table->bigInteger('id_user')->nullable();
            $table->bigInteger('id_user_update')->nullable();
            $table->integer('status')->default(3);
            $table->mediumText('comments')->nullable();
            $table->timestamps();

            $table->foreign('organization_id')
                  ->references('id')->on('category')
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
        Schema::dropIfExists('publications');
        
    }
}
