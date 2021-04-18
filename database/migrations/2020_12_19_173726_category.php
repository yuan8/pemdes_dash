<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Category extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('sub_type')->nullable();
            $table->string('name');
            $table->bigInteger('id_parent')->unsigned()->nullable();
            $table->string('slug');
            $table->string('image_path')->nullable();
            $table->string('route')->nullable();
            $table->mediumText('description')->nullable();

            $table->timestamps();
            $table->foreign('id_parent')
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
        Schema::dropIfExists('category');

    }
}
