<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsername extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('users', 'username')) {

            Schema::table('users', function (Blueprint $table) {
                $table->string('username',80)->unique();
            });

            DB::table('users')->whereNull('username')
            ->orWhere('username','=','')
            ->update([
                'username'=>DB::raw("concat('user_',id)")

            ]);
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
