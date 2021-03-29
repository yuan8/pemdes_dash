<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use FFMpeg;
use Carbon\Carbon;
class FindVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yvideo:get {tahun}';

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
        $tahun=$this->argument('tahun');
        $path=public_path('file_lombadesa/'.$tahun.'');

        exec('find '.$path.' -type f \( -iname \*.avi -o -iname \*.mp4 \)', $output, $retval);

        foreach ($output??[] as $key => $value) {
            $path_link=str_replace($path, '/file_lombadesa/'.$tahun, $value);

            $kode_daerah=explode('/', $path_link);
            $kode_daerah=isset($kode_daerah[3])?$kode_daerah[3]:null;

            $info=pathinfo($path_link);


                $thumbnail=FFMpeg::fromDisk('public_real')
                ->open($path_link)
                ->getFrameFromSeconds(55)
                ->export()
                ->save('video_thum/'.$info['filename'].'.png');

            $data=[
                'path'=>$path_link,
                'thumbnail'=>'/video_thum/'.$info['filename'].'.png',
                'judul'=>$info['filename'],
                'tahun'=>$tahun,
                'extension'=>$info['extension'],
                'kodedesa'=>$kode_daerah,
                'created_at'=>Carbon::now(),

            ];


            $v=DB::table('master_video')->where('path',$data['path'])->first();
            if($v){
                 DB::table('master_video')->where('path',$data['path'])->update(
                    [
                        'thumbnail'=>$data['thumbnail'],
                        'path'=>$path_link,
                        'extension'=>$info['extension'],

                    ]
                );

            }else{
                 DB::table('master_video')->insert(
                    $data);
            }

            DB::table('master_video')->updateOrInsert(
            [
                'path'=>$path_link,
                'tahun'=>$tahun

            ],$data);

        }
        // $this->info($output);



    }
}
