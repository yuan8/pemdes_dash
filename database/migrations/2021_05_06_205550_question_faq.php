<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionFaq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('faq_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('question');
            $table->mediumText('answer')->nullable();
            $table->bigInteger('id_category')->unsigned();
            $table->timestamps();

             $table->foreign('id_category')
                  ->references('id')->on('faq_category')
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
        Schema::dropIfExists('faq_question');

    }
}
