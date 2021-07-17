<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserWaBlash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         if (!Schema::hasColumn('users', 'wa')) {

            Schema::table('users', function (Blueprint $table) {
                $table->boolean('wa_number')->default(false);
                $table->boolean('wa_notif')->default(false);
                $table->boolean('email_notif')->default(false);

            });

           
    //
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        
    }
}
