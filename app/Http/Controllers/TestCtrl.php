<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use YDB;
use HPV;
use MyHash;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Nahid\JsonQ\Jsonq;
class TestCtrl extends Controller
{

	public function req(Request $request){

		dd($request->all());

	}



	public function tt(Request $request){

		// $table=DB::table('master_table_map')->get();

		// foreach ($table as $key => $t) {
		// 	DB::table('data')->insertOrIgnore([
		// 		'type'=>'INTEGRASI',
		// 		'delivery_type'=>'AUTOMATION',
		// 		'table_view'=>$t->key_view,
		// 		'name'=>strtoupper(str_replace('_', ' ', str_replace('dash_', 'Data ', $t->name))),
		// 		'organization_id'=>15,
		// 		'dashboard'=>1,
		// 		'id_user'=>1,

		// 	]);
		// }

		$table=DB::table('provinsi')->get();

		foreach ($table as $key => $t) {
			DB::table('category')->where('name','PEMDA PROVINSI ' .strtoupper($t->nmprovinsi))->update([
				'type'=>'INSTANSI',
				'sub_type'=>'DAERAH',
				'image_path'=>'/logo.png',
				'name'=>'PEMDA PROVINSI ' .strtoupper($t->nmprovinsi),

			]);
		}

		dd('ok');

		// $tt=DB::select("SELECT TABLE_NAME as name
		// FROM INFORMATION_SCHEMA.TABLES
		// WHERE TABLE_TYPE = 'BASE TABLE' and TABLE_SCHEMA='dash_pemdes_real' and TABLE_NAME like 'dash_%'");

		// 		// $cols=DB::table('master_column_map')->
		// 		// where('id_ms_table')->groupby('id_ms_table')
		// 		// ->select('id_ms_table')->count();


		// 		foreach($tt as $t){
		// 			$g=DB::table('data')->where([

		// 				['table_view','=',$t->name
		// 					],
		// 				['delivery_type','=','AUTOMATION']
		// 				]
		// 			)->first();
					


		// 			if($g){
						
		// 			}else{


		// 				$g=DB::table('data')->insert([
		// 					'table_view'=>$t->name,
		// 					'name'=>strtoupper(str_replace('_', ' ', str_replace('dash_', 'Data ', $t->name))),
		// 					'type'=>'INTEGRASI',
		// 					'delivery_type'=>'AUTOMATION',
		// 					'organization_id'=>15,
		// 					'dashboard'=>1,
		// 					'id_user'=>1
		// 					]
		// 				);
							
		// 			}
		// 		}

		// 		dd('cc');

		// // (session(['_regional_access'=>[11,22]]));
		// // dd(session('_regional_access'));
		// // dd($request->session()->key());


		// $x=DB::connection('mysql')->table('dash_potensi_lembaga_pemerintahan')->first();

		// foreach($x as $k=>$v){
		// 	if(!in_array($k,['kode_desa','tahun','tanggal','bulan'])){
		// 		DB::table('master_column_map')->insertOrIgnore([
		// 		'name_column'=>$k,
		// 		'aggregate_type'=>'NONE',
		// 		'name'=>strtoupper(str_replace('_', ' ', str_replace('JUMLAH', '', strtoupper($k)))),
		// 		'satuan'=>'-',
		// 		'auth'=>0,
		// 		'dashboard'=>1,
		// 		'validate'=>1,
		// 		'id_user'=>1,
		// 		'id_ms_table'=>101
				
		// 	]);
		// 	}
		// }

		// $x=DB::table('dash_potensi_luas_wilayah')->get();

		// foreach($x as $k=>$v){
		// 	// if(!in_array($k,['kode_desa','tahun','tanggal','bulan'])){
		// 	// 	DB::table('master_column_map')->insertOrIgnore([
		// 	// 	'name_column'=>$k,
		// 	// 	'aggregate_type'=>'SUM',
		// 	// 	'name'=>strtoupper(str_replace('_', ' ', $k)),
		// 	// 	'satuan'=>'Jiwa',
		// 	// 	'auth'=>0,
		// 	// 	'dashboard'=>1,
		// 	// 	'validate'=>1,
		// 	// 	'id_user'=>1,
		// 	// 	'id_ms_table'=>7
				
		// 	// ]);
		// 	// }

		// 	DB::table('dash_potensi_jenis_lahan')->insertOrIgnore([
		// 		'table'=>'dash_potensi_jenis_lahan',
		// 		'kode_desa'=>$v->kode_desa,
		// 		'id_user'=>1,
		// 		'tahun'=>2021,
		// 		'tanggal_validasi'=>Carbon::now(),
			
		// 	]);
		// }

		dd('s');
	}

	static function sort_data($data,$sort='DESC'){
		if(count($data)){
			if($sort=='DESC'){
			uasort($data,function($a,$b){
				if ($a['value']==$b['value']){
					return 0;
				}else{
					return ($a['value']<$b['value'])?1:-1;

				} 
			});
		}else{
			uasort($data,function($a,$b){
				if ($a['value']==$b['value']){
					return 0;
				}else{
					return ($a['value']<$b['value'])?-1:1;

				} 
			});
		}
		$data= array_values($data);

		}

		return $data;
	}

	static function rekap_data($data,$map,$get=4){
		$data='{"data":'.json_encode($data).'}';
		$jsonq = new Jsonq($data);
		$data=$jsonq->from('data');
		$columns=$map['columns'];
		$columns=array_values($columns);

		$sum=[];

		foreach ($columns as $key => $value) {
				if(in_array($value['aggregate_type'],['SUM','COUNT','COUNT_DISTINCT'])){
					$x=$value;
					$x['value']=$jsonq->sum('data_'.$key);
					$x['y']=$x['value'];

					$sum[$key]=$x;
				}

		}

		$sum=static::sort_data($sum,'DESC');
		
		$else=[];
		foreach ($sum as $key => $value) {
			if($key>$get){
				if(in_array($value['aggregate_type'],['SUM','COUNT','COUNT_DISTINCT'])){
					if(!isset($else[$value['satuan']])){
						$else[$value['satuan']]=[
							'name'=>$map['name'].' Lainya ('.$value['satuan'].')',
							'value'=>(float)$value['value'],
							'y'=>(float)$value['y'],
							'key'=>'...',
							'satuan'=>$value['satuan'],
							'name_column'=>'',
							'auth'=>0,
							'dashboard'=>1,
							'validate'=>1,
							'aggregate_type'=>$value['aggregate_type']
						];
					}else{
						$else[$value['satuan']]['value']+=(float)$value['value'];
						$else[$value['satuan']]['y']+=(float)$value['y'];

					}
				}
			}
		}	

		$else=array_values($else);


		return [
			'else_max'=>$else,
			'max'=>array_slice($sum,0, $get),
			'min'=>array_slice(static::sort_data($sum,'ASC'),$get)
		] ;

	}

	public function offline_donwload($tahun,Request $request){
		$data=json_decode(base64_decode($request->data),true);
		header('Content-disposition: attachment; filename=' . $data['title'].'.html');
		header('Content-type: text/html');
		$datenow=Carbon::now()->format('d F Y');
		$GLOBALS['tahun_access']=$tahun;

		return view('view_data.chart_offline')->with([
			'level'=>$data['level'],
			'title'=>$data['title'],
			'type'=>$data['type'],
			'data_type'=>$data['data_type'],
			'lavel_meta'=>$data['level_meta'],
			'table_meta'=>$data['table_meta'],
			'subtitle'=>'Capaian Tahun '.($tahun).' - '.$datenow,
		])->render().view('view_data.table')->with([
			'level'=>$data['level'],
			'title'=>$data['title'],
			'type'=>$data['type'],
			'data_type'=>$data['data_type'],
			'level_meta'=>$data['level_meta'],
			'table_meta'=>$data['table_meta'],
			'only1level'=>true,
			'subtitle'=>'Capaian Tahun '.($tahun).' - '.$datenow])
		->render();


	}



	public function view($tahun,$id,$slug=null){

		$data=DB::table('data as d')
		->join('category as c',[['c.id','=','d.organization_id'],['c.type','=',DB::raw("'INSTANSI'")]])
		->leftjoin('master_table_map as m','m.key_view','=','d.table_view')
		->selectRaw("d.*, c.name as i_name,c.id as i_id,c.type as i_type,m.id as id_table_map")
		->where(['d.id'=>$id,'d.type'=>'INTEGRASI']);

		$data=$data->first();

	
		if($data){
			$table_view=DB::table('master_table_map')->where('key_view',$data->table_view)->first();
			if($table_view){

				if(!Auth::check()){
					if($data->auth!=false){
						$GLOBALS['ab_message']=['title'=>$data->name];
						return abort('401');
					}
				}

				$provinsi=DB::table('provinsi')->where('kdprovinsi','>',0)->get();

				if($table_view->start_level>1000){
					return view('view_data.desa')->with(['data'=>$data,'hm'=>true,'provinsi'=>$provinsi]);
				}else{
					return view('view_data.test')->with(['data'=>$data,'hm'=>true]);

				}



			}



		}else{
			$GLOBALS['ab_message']=['title'=>$data->name];
			return abort('404')->with('title',$data->name);
		}

	}

	
	public function index($tahun,$id,$table,Request $request){
		$meta_data=DB::table('data as d')->where('id',$id);
		if(!Auth::check()){
			$meta_data=$meta_data->where('d.auth',false);
		}

		$meta_data=$meta_data->first();

		if(!$meta_data){

				return view('view_data.api_no_access');
		}


		$meta_table=HPV::gen_map($meta_data->table_view,1,$request->kdparent);
		// dd($meta_table);

		if(!$meta_table){
			return abort(404);
		}
			

		$table=$meta_table['table'];

		$aggregate=true;

	
		if($meta_table['start_level']>1000){
			$level=HPV::level($request->kdparent,$meta_table['start_level']);
			$level2=HPV::level($request->kdparent??0);
		}else{
			$level=HPV::level($request->kdparent??0);
			$level2=$level;
		}			



		if($level['count']>=9){
			$aggregate=false;
			
		}




		if($meta_table and $level){
			if($request->kdparent){
			$nama_pemda=((array)DB::table($level2['parent']['table'])
			->selectRaw("concat('".$level['parent']['level']." '".','.$level2['parent']['table_name'].') as name')->where($level2['parent']['table_kode'],$request->kdparent)->first())['name'];
			}else{
				$nama_pemda='Per Provinsi';
			}

			$select= 
			// "cfm.id as id_cmf, ".
			"'".$id."'".' as id_data,'.' kd.'.$level['table_kode']." as id, kd.".$level['table_name']." as name ".($level['count']!=10?", (select count(distinct(dds.kode_dagri)) from master_desa as dds where left(dds.kode_dagri,".$level['count'].") = kd.".$level['table_kode']." ) as jumlah_desa , count(distinct(data.kode_desa)) as jumlah_data_desa":",(kd.stapem) as status_desa");

			if($aggregate){
					foreach (array_values($meta_table['columns']) as $key => $value) {
				$OP=HPV::translate_operator($value['aggregate_type']);
				$select.=" , ".$OP[1]." data.".$value['name_column'].$OP[2].' as data_'.$key." , '".$value['satuan']."' as data_".$key."_satuan";

				}
			}else{
				foreach (array_values($meta_table['columns']) as $key => $value) {
				$OP=HPV::translate_operator($value['aggregate_type']);
				$select.=" , data.".$value['name_column'].' as data_'.$key." , '".$value['satuan']."' as data_".$key."_satuan";

				}
			}

			$data=[];
			$desa_only=false;


			$paginate=$meta_table['start_level']>1000000000000?50:200;
			if($meta_table['start_level']>1000000000000000){
				$desa_only=true;
			}


			$last_kode='';
			$data_get=0;
			$last_page=1;
			$count_total=DB::table(DB::raw("(select *  from ".$level['table']." as ddd where ddd.".$level['table_kode']." like '".($level['kode']?$level['kode'].'%':"%")."') as kd"))
			->join(DB::raw("(select * from ".$meta_table['table']." as dxdx)  as data"),
				[[DB::raw("left(data.kode_desa,".$level['count'].")"),'=','kd.'.$level['table_kode']],['data.tahun','=',DB::raw($tahun)]])
			->selectRaw("count(distinct(".('kd.'.$level['table_kode']).")) as count")
			->whereRaw('(kd.'.$level['table_kode']." <> '0' and kd.".$level['table_kode']." <> '00') ")
			->orderBy('kd.'.$level['table_kode'], 'asc')->pluck('count')
			->first();


			$x=DB::table(DB::raw("(select *  from ".$level['table']." as ddd where ddd.".$level['table_kode']." like '".($level['kode']?$level['kode'].'%':"%")."') as kd"))
			->join(DB::raw("(select * from ".$meta_table['table']." as dxdx)  as data"),
				[[DB::raw("left(data.kode_desa,".$level['count'].")"),'=','kd.'.$level['table_kode']],['data.tahun','=',DB::raw($tahun)]])

			// if($desa_only){
			// 	$x=$x->
			// }
			->selectRaw($select)
			->groupBy(('kd.'.$level['table_kode']) )
			->whereRaw('(kd.'.$level['table_kode']." <> '0' and kd.".$level['table_kode']." <> '00') ")
			->orderBy('kd.'.$level['table_kode'], 'asc')
			->limit($paginate)
			->get()->toArray();

			if(count($x)){
				$data_get=count($x);
				$last_page=((int)($count_total/$paginate));
				if($last_page<=0){
					$last_page=1;
				}
				$last_kode=((array)$x[$data_get-1])['id'];
			}


			$data=$x;
			if($meta_table['start_level']<1000000000000){
				if($paginate<$count_total){

					for ($p=2;$p<=$last_page;$p++) {
						// $_REQUEST['page']=$p;
						//  Paginator::currentPageResolver(function () use ($p)  {
					 //        return $p;
					 //    });

						$y=DB::table(DB::raw("(select *  from ".$level['table']." as ddd where ddd.".$level['table_kode']." like '".($level['kode']?$level['kode'].'%':"%")."') as kd"))
			
						->join(DB::raw("(select * from ".$meta_table['table']." as dxdx)  as data"),
						[
						[DB::raw("left(data.kode_desa,".$level['count'].")"),'=','kd.'.$level['table_kode']],['data.tahun','=',DB::raw($tahun)]])
						->selectRaw($select)
						->groupBy(('kd.'.$level['table_kode']) )
						->whereRaw('(kd.'.$level['table_kode']." <> '0' and kd.".$level['table_kode']." <> '00') ")
						->orderBy('kd.'.$level['table_kode'], 'asc')
						->where('kd.'.$level['table_kode'],'>',$last_kode)
						->limit($paginate)
						->get()->toArray();

						$data=array_merge($data,$y);

						if(count($y)){
							$data_get=count($y);
							$last_kode=((array)$y[$data_get-1])['id'];
						}
					}
				}
			}

			$data_type=[
				'data'=>$data
			];

			$datenow=Carbon::now()->format('d F Y');

			if($meta_table['start_level']>1000){
				return '<div class="table-responsive ch col-md-12">'.view('view_data.table')->with([
						'data_type'=>$data_type,
						'title'=>strtoupper($meta_data->name),
						'subtitle'=>'Capaian Tahun '.($tahun).' - '.$datenow,
						'level'=>$level['count'],
						'level_meta'=>$level,
						'kdparent'=>$level['kode'],
						'pemda'=>$nama_pemda,
						'table_meta'=>$meta_table,
						'data'=>$meta_data,
						'tahun_capaian'=>$tahun,
					])->render().'</div>';
			}



			$data_type['series']=static::data_series($meta_table['key_view'],$data,$meta_table,$level,$id);
			$data_type['series_map']=static::data_map($meta_table['key_view'],$data,$meta_table,$level,$id);

			$data_type['data_sort']=static::rekap_data($data,$meta_table,4);

			$meta_entity=isset($meta_table['view_'][$level['count']])?$meta_table['view_'][$level['count']]:[];

			
			$id_c='chart_id_'.rand(0,100).'_'.date('Ymdhi');
			$return='<div class="row " id="'.$id_c.'">';
			if(count($meta_entity)==0){
				$return.='<div class="col-md-12"><h4 class="text-center">DATA TIDAK TERSEDIA</h4></div>';
			}
			foreach ($meta_entity as $key => $value) {
				foreach($value as $v){
						$return.='<div class="table-responsive ch col-md-'.(12/count($value)).' col-lg-'.(12/count($value)).'">'.view('view_data.'.$v)->with([
						'data_type'=>$data_type,
						'title'=>strtoupper($meta_data->name),
						'subtitle'=>'Capaian Tahun '.($tahun).' - '.$datenow,
						'level'=>$level['count'],
						'level_meta'=>$level,
						'kdparent'=>$level['kode'],
						'pemda'=>$nama_pemda,
						'table_meta'=>$meta_table,
						'data'=>$meta_data,
						'tahun_capaian'=>$tahun,
					])->render().'</div>';
					
				}
			}
			$return.='</div>
			';


			
			return ($return!='')?$return:'TIDAK TERDAPAT DATA';

		}

	}


	
	public static function data_series($table,$data,$map,$level,$md,$jenis='INT'){

		$D=[];

		$satuan=[];
		$SATUAN_X=[];
		foreach($data as $d){
			$d=(Array)$d;
			foreach (array_values($map['columns']) as $k => $m) {
				if(!isset($satuan[$m['satuan']])){
					$satuan[$m['satuan']]=$m['satuan'];
				}

				$SATUAN_X=array_values($satuan);

				# code...
				if(!isset($D[$m['name_column']])){
					$D[$m['name_column']]=[
						'name'=>(HPV::translate_operator($m['aggregate_type']))[0].' '.$m['name'],
						'yAxis'=>array_search($m['satuan'], $SATUAN_X),
						'visible'=>($k>2)?false:true,
						'data'=>[]

					];
				}

				if($jenis=='INT'){
					$ROUTE_NEXT=($level['count'])?route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'table'=>$table,'kdparent'=>$d['id']]):null;
				}else{
					$ROUTE_NEXT=($level['count'])?route('visual.dataset',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'kdparent'=>$d['id']]):null;
				}
				

				$D[$m['name_column']]['data'][]=[
					'id'=>$d['id'],
					'name'=>$d['name'],
					'y'=>(float)$d['data_'.$k]??0,
					'value'=>(float)$d['data_'.$k]??0,
					'satuan'=>$d['data_'.$k.'_satuan'],
					'route'=>$ROUTE_NEXT,
					'next_dom'=>$level['count'],

				];

			}
		}

		$yAxis=[];

		foreach ($SATUAN_X as $key => $y) {
			$yAxis[]=[
				'gridLineDashStyle'=>((($key+1)%2)==0)?'longdash':'solid',
				'label'=>[
					'format'=>'{value} '.$y
				],
				'title'=>[
					'text'=>$y
				],
				'opposite'=>((($key+1)%2)==0)?1:0,
			];
		}


		return [
			'yAxis'=>$yAxis,
			'data'=>
			array_values($D)
		];


	}


	public static function data_map($table,$data,$map,$level,$md,$jenis='INT'){

		$D=[];

		$satuan=[];

		foreach($data as $d){
			$d=(Array)$d;
			if(!isset($d['jumlah_desa'])){
				$d['jumlah_desa']=1;
			}
			if(!isset($d['jumlah_data_desa'])){
				$d['jumlah_data_desa']=1;
			}

			$data_map=[];
			$data_map[0]=[
				'name'=>'Keterisian Data',
				'y'=>(((float)$d['jumlah_data_desa']!=0) AND ((float)$d['jumlah_desa']!=0) )?(
					((float)$d['jumlah_data_desa'])/((float)$d['jumlah_desa'])*100
				):0,
				'satuan'=>'%',
				
			];
			$data_map[0]['value']=(float)$data_map[0]['y'];

			$data_map[1]=[
				'name'=>'Jumlah Desa',
				'y'=>(((float)$d['jumlah_desa'])),
				'value'=>(((float)$d['jumlah_desa'])),
				'satuan'=>'Desa',
			];
			$data_map[2]=[
				'name'=>'Jumlah Desa Terdata',
				'y'=>(((float)$d['jumlah_data_desa'])),
				'value'=>(((float)$d['jumlah_data_desa'])),
				'satuan'=>'Desa',
			];

			// foreach (array_values($map['columns']) as $k => $m) {
			// 	# code...
				
			// 	if(strtoupper($d['data_'.$k.'_satuan'])=='DESA'){
			// 		if($level['count']==10){
			// 			$d['data_'.$k.'_satuan']='-';
			// 			$d['data_'.$k]=($d['data_'.$k]?'Ada':'Tidak');
			// 		}
			// 	}

			// 	$data_map[]=[
			// 		'name'=>(HPV::translate_operator($m['aggregate_type']))[0].' '.$m['name'],
			// 		'y'=>(float)$d['data_'.$k]??0,
			// 		'value'=>(float)$d['data_'.$k]??0,
			// 		'satuan'=>$d['data_'.$k.'_satuan'],
			// 	];

			// }

			if($jenis=='INT'){
				$ROUTE_NEXT=($level['count'])?route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'table'=>$table,'kdparent'=>$d['id']]):null;
			}else{
				$ROUTE_NEXT=($level['count'])?route('visual.dataset',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'kdparent'=>$d['id']]):null;
			}
			$D[]=[

				'name'=>$d['name'],
				'id'=>$d['id'],
				'value'=>$data_map[0]['y'],
				'y'=>$data_map[0]['y'],

				'route'=>$ROUTE_NEXT,
				'next_dom'=>$level['count'],
				'data_map'=>$data_map
			];

		}




		return [
			'yAxis'=>[

			],
			'data'=>
			array_values($D)
		];
	}
}