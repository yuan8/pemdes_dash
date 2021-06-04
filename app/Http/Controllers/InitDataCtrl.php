<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
use Carbon\Carbon;
class InitDataCtrl extends Controller
{
    
	public function server_(){
		$MAP=DB::connection('server')->table('master_table_map')
		->get();

		$MAP_EXITING=DB::table('master_table_map')
		->get();

		foreach($MAP as $m){
			if(!in_array($m->table,$MAP_EXITING->pluck('table')->toArray())){
				// DB::table('master_table_map')
				// dd($MAP_EXITING[0]);
				$column=DB::connection('server')->table('master_column_map')
				->where('id_ms_table',$m->id)->get();
				// $column2=DB::table('master_column_map')
				// ->first();






				$id_map=DB::table('master_table_map')
				->insertGetId([
					'name'=>$m->name,
					'table'=>$m->table,
					'edit_daerah'=>1,
					'inheritance'=>1,
					'start_level'=>2,
					'stop_level'=>10,
					'id_user'=>1,
					'created_at'=>Carbon::now(),
					'updated_at'=>Carbon::now(),

				]);

				foreach ($column as $key => $value) {
					$value=(array)$value;
					unset($value['id']);
					$value['id_ms_table']=$id_map;
					$column[$key]=(array)$value;

				

					DB::table('master_column_map')->insertOrIgnore($value);
				}

			}
		}

		
		dd($MAP,$MAP_EXITING);
	}


	public static function list_desa($table){
		$con_server=env('DB_CON_INTEGRASI');
		$get_id=DB::table('master_desa as ds')
		->leftjoin($table.' as d')->whereRaw(
			"
			(ds.kddesa is not null and d.kode_desa is null) or 
			(d.status_validasi =0 or d.status_validasi=null)
			"
		)->selectRaw('ds.kddesa')->get()->pluck('kddesa')->toArray();

	}

	public static function list_column($id_table){

		$column=DB::table('master_column_map')->where('id_ms_table',$id_table)
		->get();
		if(count($table)){
			return $column->pluck('name_column')->toArray()['kode_desa'];
		}else{
			return false;
		}
	}

	public static function update_integrasi($id_table,$tahun){
		$table=DB::table('master_table_map')->where('id',$id_table)
		->first();
		if($table){
			$column=static::list_column($table->id);
			$row_=static::list_column($table->id);

		}
		$table=DB::table($table)
		->selectRaw()
		->where('id_table',$id_table)
		->get();
		if(count($table)){
			return $table->pluck('name_column')->toArray()['kode_desa'];
		}else{
			return false;
		}

	}


	public function createFile(){

		$con=env('DB_CON_INTEGRASI');
		$exist=[];
		$dir=scandir(storage_path('app/init-sql'));
		// $check=DB::connection('server')
		// ->table('users')->get();

		$check=DB::connection($con)
		->table('INFORMATION_SCHEMA.TABLES')
		->where([
			['TABLE_SCHEMA','=',config('database.connections.'.$con.'.database')],
			['TABLE_NAME','like','dash_%']
		])->get();



		foreach ($check as $key => $value) {
			# code...
			$phps='
<?php

return [
"name"=>"'.$value->TABLE_NAME.'"
"sql_create"=>""
];
			';


			if(!in_array($value->TABLE_NAME.'.php',$dir)){
				$exist[]=$value->TABLE_NAME.'.php';
				Storage::put('init-sql/'.$value->TABLE_NAME.'.php',$phps);

			}
		}
		dd($exist);
	}
	public function index(){
		$dir=scandir(storage_path('app/init-sql'));
		$exist=[];
		foreach ($dir as $key => $file) {
			if(!in_array($file,['.','..'])){
				$todo=include(storage_path('app/init-sql/'.$file));
					$check=DB::table('INFORMATION_SCHEMA.TABLES')->where([
						['TABLE_SCHEMA','=',env('DB_DATABASE')],
						['TABLE_NAME','=',$todo['name']]
					])->first();


					if(!$check){
						if($todo['sql_create']){
								$loop=DB::statement($todo['sql_create']);
						$exist[$todo['name']]='NEW';
						}
					
					}

					if($check){
						$exist[$todo['name']]='EXITS '.$check->CREATE_TIME;
					}



			}
			
		}

		dd($exist,count($exist));
	}
}
