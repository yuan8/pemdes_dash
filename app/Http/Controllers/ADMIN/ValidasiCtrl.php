<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use HPV;
use Carbon\Carbon;
use Auth;
class ValidasiCtrl extends Controller
{	

	public function validated($tahun,$table,$id,Request $request){
		$data=DB::table('validasi_confirm as cfm')->where(
			[
				['tahun','=',$tahun],
				['table','=',$table],
				['kode_desa','=',$id]
			]
		)->first();

		if(!$data){
			$data=DB::table('validasi_confirm')->insert([
				'tahun'=>$tahun,
				'table'=>$table,
				'kode_desa'=>$id,
				'tanggal_validasi'=>Carbon::parse($request->updated_at),
				'keterangan'=>$request->keterangan,
				'id_user'=>Auth::User()->id
			]);

			return back();
		}

		return back();

	}

	public function index($tahun,Request $request){
		$table=HPV::table_data();
		$data_index=0;
		if($request->data){
			$data_index=$request->data;
		}

		$provinsi=DB::table('provinsi')->where('kdprovinsi','!=','0')->where('kdprovinsi','!=','00')->get();

		$kodedaerah=[
			'kdprovinsi'=>null,
			'kdkota'=>null,
			'kdkecamatan'=>null,
			'kddesa'=>null,
		];



		if($request->kdprovinsi){
			$kodedaerah['kdprovinsi']=$request->kdprovinsi;
		}

		if($request->kdkota){
			$kodedaerah['kdkota']=$request->kdkota;

		}

		if($request->kdkecamatan){
			$kodedaerah['kdkecamatan']=$request->kdkecamatan;
			$daerah=DB::table('master_desa')->where('kode_bps',$kodedaerah['kddesa'])->fisrt();


		}

		if($request->kddesa){
			$kodedaerah['kddesa']=$request->kddesa;
			$daerah=DB::table('master_desa')->where('kode_bps',$kodedaerah['kddesa'])->fisrt();
		}




		return view('admin.validasi.index')->with([
			'provinsi'=>$provinsi,'kodedaerah'=>$kodedaerah,'data_index'=>$data_index,'table'=>$table]);
	}

	public function data($tahun,Request $request){
		$table=HPV::table_data();
		$data_index=0;
		$daerah=NULL;
		if($request->data){
			$data_index=$request->data;
		}
		$where=[];
		if($request->kdprovinsi){
			$where[]=[DB::raw("left(d.kode_desa,2)"),'=',$request->kdprovinsi];
			$daerah=DB::table('provinsi')

			->where('kdprovinsi',$request->kdprovinsi)
			->selectRaw("
				'' as parent,
				kdprovinsi as id,'PROVINSI' as jenis,nmprovinsi as name")
			->first();
		}


		if($request->kdkota){
			$where[]=[DB::raw("left(d.kode_desa,4)"),'=',$request->kdkota];
			$daerah=DB::table('kabkota')
			->where('kdkabkota',$request->kdkota)
			->selectRaw("'".$daerah->jenis.' '.$daerah->name." -> ' as parent,kdkabkota as id,'KAB/KOTA' as jenis,nmkabkota as name")
			->first();
		}



		if($request->kdkecamatan){
			$where[]=[DB::raw("left(d.kode_desa,7)"),'=',$request->kdkecamatan];
			$daerah=DB::table('kecamatan')
			->where('kdkecamatan',$request->kdkecamatan)->selectRaw("'".$daerah->parent." ".$daerah->name." -> ' as parent,
				kdkecamatan as id,'KECAMATAN' as jenis,nmkecamatan as name")
			->first();
		}


		if($request->kddesa){
			$where[]=[DB::raw("(d.kode_desa)"),'=',$request->kddesa];
			$daerah=DB::table('master_desa')
			->where('kode_bps',$request->kddesa)->selectRaw("'".$daerah->parent." ".$daerah->jenis." ".$daerah->name." -> ' as parent,
				kode_bps as id, 'DESA' as jenis,desa as name")
			->first();

		}

		$data=DB::table($table[$data_index]['table'].' as d')
		->join('master_desa as md','md.kode_bps','=','d.kode_desa')
		->leftJoin('kecamatan as mkc',DB::raw("left(d.kode_desa,7)"),DB::raw('='),DB::raw('mkc.kdkecamatan'))
		->leftJoin('validasi_confirm as cfm',[
			[DB::raw("(d.kode_desa)"),'=',DB::raw('cfm.kode_desa')],
			['cfm.table','=',DB::RAW("'".$table[$data_index]['table']."'") ],
			['cfm.tahun','=',DB::RAW($tahun)]
		])
		->selectRaw(" (case when (cfm.id) then 'Valid' else 'Belum Divalidasi' end)  as Status_Verifikasi_Data, md.desa as Nama_Desa, mkc.nmkecamatan as Nama_Kecamatan,d.*");
		if(count($where)>0){
			$data=$data->where($where);
		}



		$data=$data->paginate(10);

		$verifikasi=[
			'sudah'=>(int)DB::table($table[$data_index]['table'].' as d')
			->join('master_desa as md','md.kode_bps','=','d.kode_desa')
			->join('validasi_confirm as cfm',[[DB::raw("(d.kode_desa)"),'=',DB::raw('cfm.kode_desa')],['cfm.table','=',DB::RAW("'".$table[$data_index]['table']."'")],['cfm.tahun','=',DB::raw($tahun)]])
			->count(),
			
		];
		$verifikasi['belum']=$data->total()-$verifikasi['sudah'];

		$data=$data->appends([
			'kddesa'=>$request->kddesa,
			'kdprovinsi'=>$request->kdprovinsi,
			'kdkota'=>$request->kdkota,
			'kdkecamatan'=>$request->kdkecamatan,
			'data'=>$request->data,
		]);

		$req=[
			'kddesa'=>$request->kddesa,
			'kdprovinsi'=>$request->kdprovinsi,
			'kdkota'=>$request->kdkota,
			'kdkecamatan'=>$request->kdkecamatan,
		];

		return view('admin.validasi.data')
		->with(['daerah'=>$daerah,'data'=>$data,'req'=>$req,'data_index'=>$data_index,'table'=>$table,'rekap'=>$verifikasi]);
	}


	public function getData($tahun,$table,$kodedesa){
		$data=DB::table($table[0]['table'])->get();

	}


}