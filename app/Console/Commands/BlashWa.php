<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotifChangeDataCtrl;


class BlashWa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wa:blash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $token=config('services.chatapi.token');
        $url=config('services.chatapi.api_url');


        $this->info("token  ".$token);
        $this->info("url ".$url);
        $n=NotifChangeDataCtrl::notifWa();
        


        dd($n);


    }
}
