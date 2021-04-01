<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use FFMpeg;
use Carbon\Carbon;
use Pomirleanu\GifCreate;
use Storege;
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
        $path=public_path('file_lombadesa/'.$tahun.'/');

        exec('find '.$path.' -type f \( -iname \*.avi -o -iname \*.mp4 \)', $output, $retval);

        foreach ($output??[] as $key => $value) {
           

            $path_link=str_replace($path, '/file_lombadesa/'.$tahun.'/', $value);
            preg_match('/[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]/', $value, $output_array);
            $kodedesa='';

            if(count($output_array??[])){
                $kodedesa=($output_array[0]);
            }

            $kode_daerah=explode('/', $path_link);
            $kode_daerah=isset($kode_daerah[3])?$kode_daerah[3]:null;

                $info=pathinfo($path_link);
                $name_file_r='video_thum/'.$tahun.'/'.$kodedesa.'/'.$info['filename'];
                $name_file_r_tmp='video_thum/'.$tahun.'/TMP/'.$kodedesa.'_'.$info['filename'];


                $name_file=$name_file_r.'.jpg';
                $second_start=2;

                $thumbnail=FFMpeg::fromDisk('public_real')
                ->open($path_link)
                ->getFrameFromSeconds(55)
                ->export()
                ->save($name_file);


                $data_path_gif=[];
                $durations=[];

               

                // Storage::disk('public_real')->put(,$gif->encode());
                // dd($name_file_r.'.gif');

            $data=[
                'path'=>$path_link,
                'thumbnail'=>'/'.$name_file,
                'judul'=>$info['filename'],
                'tahun'=>$tahun,
                'extension'=>$info['extension'],
                'kodedesa'=>$kode_daerah,
                'created_at'=>Carbon::now(),

            ];
            $up=[];

             for ($i=0; $i <20 ; $i++) { 

                    $durations[]=20;
                    FFMpeg::fromDisk('public_real')
                    ->open($path_link)
                    ->getFrameFromSeconds($second_start+($i*2))
                    ->export()
                    ->save($name_file_r_tmp.'_'.$i.'.jpg');

                    $data_path_gif[]=public_path($name_file_r_tmp.'_'.$i.'.jpg');

                    
                }

                $gif = new GifCreate\GifCreate();
                $gif->create($data_path_gif, $durations);
                $gif->save(public_path($name_file_r.'.gif'));

            $v=DB::table('master_video')->where('path',$data['path'])->first();
            if($v){
                $up[]=$data['thumbnail'];
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
        shell_exec('rm -r '.public_path('video_thum/'.$tahun.'/TMP'));

        $this->info('success...');

        dd($output,'update',$up);





    }
}
