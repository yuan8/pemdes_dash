<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Data extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

           Schema::create('data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('delivery_type');
            $table->string('name');
            $table->string('extension')->nullable();
            $table->float('size')->default(0);
            $table->string('document_path')->nullable();
            $table->integer('year')->nullable();
            $table->text('tags')->nullable();
            $table->text('keywords')->nullable();
            $table->bigInteger('organization_id')->unsigned()->nullable();
            $table->mediumText('description')->nullable();
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
        Schema::dropIfExists('data');

    }
}
