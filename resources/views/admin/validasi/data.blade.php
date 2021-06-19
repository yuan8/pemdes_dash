@extends('vendor.adminlte.admin')
@section('content_header')
<h4>{{$GLOBALS['tahun_access']}} - VALIDASI DATA <b>{{($daerah)}}</b></h4>
<hr style="border-color: #fff">
@php
	$berita_acara=HP::berita_acara($kode_daerah,$GLOBALS['tahun_access'],$table_map['id_map']);
@endphp
@if($time_count_down??0 > 0)
	<div  id="time_count">
		<h5><b>WAKTU PENGISIAN : </b>
			<span class="badge bg-maroon"><b><i>@{{days}} Hari</i></b> <b><i>@{{hours}} Jam</i></b>
			<b><i>@{{minutes}} Menit</i></b>
			<b><i>@{{seconds}} Detik</i></b></span>
		</h5>
	</div>
@endif

<div class="form-group">
	<label>DATA</label>
	<form method="get" action="{{url()->full()}}">
		<div class="row">
		<div class="col-md-4">
			@foreach($req as $keyr=>$r)
				<input type="hidden" name="{{$keyr}}" value="{{$r}}">
			@endforeach
			<select class="form-control" name="data"  id="data" onchange="$(this).parent().parent().parent().submit()">
				@foreach($table as $key=>$t)
					<option value="{{$t->id}}" {{$data_index==$t->id?'selected':''}}>{{$t->name}}</option>
				@endforeach
			</select>
			</div>
			<div class="col-md-8">
				<div class="btn-group">
					@if($req['kdprovinsi'])
						<button type="button" onclick="get_user_list({{$req['kdprovinsi']}})" class="btn btn-default"><i class="fa fa-users"></i> User Provinsi</button>
					@endif
					@if($req['kdkabkota'])
						
						<button type="button" onclick="get_user_list({{$req['kdkabkota']}})"   class="btn btn-default"> <i class="fa fa-users"></i> User Kob/Kota</button>
					@endif
					@if($req['kdkecamatan'])
						<button type="button" onclick="get_user_list({{$req['kdkecamatan']}})" class="btn btn-default"><i class="fa fa-users"></i> User Kecamatan</button>
					@endif
					@if($req['kddesa'])
						<button type="button" onclick="get_user_list({{$req['kddesa']}})" class="btn btn-default"><i class="fa fa-users"></i> User Desa</button>
					@endif
				</div>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		$('#data').select2();
	</script>
	</div>
	<hr style="border-color: #fff">
	

<div class="row bg-navy no-gutter" style=" padding-top: 10px;" >
	<div class="col-md-12">
		<h4><b>{{$nama_data}}</b></h4>
<hr style="border-color: #fff">

	</div>
	<div class="{{HP::verifikasi_status_level($kode_daerah)['level']=='-'?'col-md-4':'col-md-3'}}">
		<div class="box-solid box bg-yellow">
			<div class="box-header with-border">
				<h4><b>Jumlah Data</b></h4>
			</div>
		<div class="box-body">
			<p>{{HPV::nformat($rekap['total'])}} DESA</p>
		</div>
	</div>
	</div>
	<div class="{{HP::verifikasi_status_level($kode_daerah)['level']=='-'?'col-md-4':'col-md-2'}}">
		<div class="box-solid box bg-green">
			<div class="box-header with-border">
				<h4><b>Data Valid </b></h4>
			</div>
		<div class="box-body">
			<p>{{HPV::nformat($rekap['sudah'])}} DESA</p>
		</div>
	</div>
	</div>
	<div class="{{HP::verifikasi_status_level($kode_daerah)['level']=='-'?'col-md-4':'col-md-3'}}">
		<div class="box-solid box bg-maroon">
			<div class="box-header with-border">
				<h4><b>Data Belum Valid</b></h4>
			</div>
		<div class="box-body">
			<p>{{HPV::nformat($rekap['belum'])}} DESA</p>
		</div>
	</div>
	</div>
	@if(HP::verifikasi_status_level($kode_daerah)['level']!='-')
	<div class="col-md-4">

		<div class="box-solid box bg-blue">
			<div class="box-header with-border">
				<h4 class="text-capitalize"><b>Terverifikasi {{strtolower(HP::verifikasi_status_level(strlen($kode_daerah)<=6?'101010':$kode_daerah)['level'])}} </b></h4>
			</div>
			<div class="box-body">
				<p>{{HPV::nformat($rekap['verifikasi'])}} DESA</p>
			</div>
		</div>
	</div>
	@endif
	<div class="col-md-12">
		<h5>AKSI</h5>
		<div class="btn-group">
			
			@if($berita_acara==null)
		
			@elseif($berita_acara['access'])
				@if($berita_acara['berita_acara'])
					<a href="{{$berita_acara['berita_acara']}}" download="" class="btn btn-primary">DOWNLOAD BERITA ACARA</a>
						@if($time_count_down and (strlen($kode_daerah)==4))

							<button onclick="hapus_berita_acara('{{route('admin.validasi.berita_acara.delete',array_merge(['tahun'=>$GLOBALS['tahun_access'],'kdkabkota'=>$req['kdkabkota'],'data'=>$req['data']]))}}')" class="btn btn-danger"><i class="fa fa-trash"></i> HAPUS BERITA ACARA</button>
						@else
						@can('is_admin')
						@if((strlen($kode_daerah)==4))
						<button onclick="hapus_berita_acara('{{route('admin.validasi.berita_acara.delete',array_merge(['tahun'=>$GLOBALS['tahun_access'],'kdkabkota'=>$req['kdkabkota'],'data'=>$req['data']]))}}')" class="btn btn-danger"><i class="fa fa-trash"></i> HAPUS BERITA ACARA</button>
						@endif
						@endcan
					@endif
				@else
					@can('is_daerah_kabkota_n_admin')
					@if((strlen($kode_daerah)==4))
					<a href="javascript:void(0)" onclick="build_berita_acara('{{route('admin.validasi.berita_acara.build',array_merge(['tahun'=>$GLOBALS['tahun_access'],'kdkabkota'=>$req['kdkabkota'],'data'=>$req['data']]))}}')" class="btn btn-danger">BUAT BERITA ACARA</a>
					@endif
					@endcan

					<a href="{{url()->full().'&export_format=FORM'}}" download="" class="btn btn-primary"> DOWNLOAD FORM</a>
					<a href="{{route('admin.validasi.upload',['tahun'=>$GLOBALS['tahun_access'],'kdprovinsi'=>$req['kdprovinsi'],'kdkabkota'=>$req['kdkabkota'],'kdkecamatan'=>$req['kdkecamatan'],'kddesa'=>$req['kddesa'],'data'=>$req['data']])}}" class="btn btn-success ">UPLOAD DATA PERUBAHAN</a>
				@endif
			@elseif($berita_acara['access_form'])
				<a href="{{url()->full().'&export_format=FORM'}}" download="" class="btn btn-primary"> DOWNLOAD FORM</a>
					<a href="{{route('admin.validasi.upload',['tahun'=>$GLOBALS['tahun_access'],'kdprovinsi'=>$req['kdprovinsi'],'kdkabkota'=>$req['kdkabkota'],'kdkecamatan'=>$req['kdkecamatan'],'kddesa'=>$req['kddesa'],'data'=>$req['data']])}}" class="btn btn-success ">UPLOAD DATA PERUBAHAN</a>
			@endif
	
			
			

			
		</div>
	</div>
</div>


@stop


@section('content')
@if($berita_acara['berita_acara'])
<iframe src="{{$berita_acara['berita_acara']}}" style="width:100%; border:none; height: 500px;" ></iframe>
	
@else
<div class="box box-primary">
	<div class="box-header with-border">
		<form action="" method="get" action="{{url()->full()}}">
			@foreach($req as $keyr=>$r)
				<input type="hidden" name="{{$keyr}}" value="{{$r}}">
			@endforeach
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>STATUS DARAH</label>
						<select class="form-control" name="status_daerah" onchange="$(this).parent().parent().parent().parent().submit()">
							<option value="" {{$req['status_daerah']==''?'selected':''}}>SEMUA</option>
							<option value="DESA" {{$req['status_daerah']=='DESA'?'selected':''}}>DESA</option>
							<option value="KELURAHAN" {{$req['status_daerah']=='KELURAHAN'?'selected':''}}>KELURAHAN</option>
						</select >
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>VERIFIKASI STATUS</label>
						@php
						@endphp
						<select class="form-control" name="verifikasi_status" onchange="$(this).parent().parent().parent().parent().submit()">
							<option value="NULL">Semua</option>
							@foreach (HP::verifikasi_list() as $vl)
								@php
									if($req['verifikasi_status']!==NULL){
										$sel=(($vl['id']===(int)$req['verifikasi_status'])?'selected':'');
									}else{
										$sel='';
									}
									
								@endphp
								<option value="{{$vl['id']}}" {{$sel}} >{{$vl['text']}}</option>
								{{-- expr --}}
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>CARI DAERAH</label>
						<input type="text" class="form-control" name="q" value="{{$req['q']}}">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="box-body ">
		@if(strlen($kode_daerah)==6)
		<div class="row bg-maroon">
			@if(Auth::User()->can('is_only_daerah_verifikasi'))
				<div class="col-md-12 text-center" style="border-top:2px solid #fff; padding-bottom: 10px; padding-top: 10px;" >
					<p class="text-center"><b><i>

					KUNCI  "{{$nama_data}}" TERVERIFIKASI  KEDALAM DRAF BERITA ACARA</i></b> </p>
					<form>
					@csrf
					<input type="hidden" name="id_map" value="{{$data_index}}">
					<button class="btn bg-navy" type="submit"><i class="fa fa-key"></i> KUNCI DATA</button>
					</form>
				</div>
				
			@endif
		</div>
		@endif
		<h5><b>TOTAL DATA : {{count($data)}} DATA</b></h5>
		@if(count($data)>0)

			<div class="table-responsive">
				<table class="table-bordered table">
			<thead>
				<tr>
					<th rowspan="2" style="width:80px;">AKSI</th>
					<th rowspan="2" style="width:80px;" >NO</th>

					<th rowspan="2" >KODE</th>
					<th rowspan="2" >UPDATED AT</th>
					<th rowspan="2" >NAMA DESA</th>
					<th rowspan="2" >STATUS DAERAH</th>
					<th rowspan="2" >NAMA KECAMATAN</th>
					<th rowspan="2" >NAMA KOTA/KAB</th>
					<th rowspan="2" >NAMA PROVINSI</th>
					<th rowspan="2" >STATUS DATA</th>



					@foreach($table_map['columns'] as $key=>$x)
						@php
						@endphp
						<th colspan="2">{{strtoupper($x['name'].' ('.$x['satuan'].')')}}</th>
					@endforeach
				</tr>
				<tr>
					@foreach($table_map['columns'] as $key=>$x)
						@php
						@endphp
						<th>DEFINISI</th>
						<th>
							NILAI
						</th>
					@endforeach
				</tr>
			</thead>
			@php
				$total=[];
			@endphp
			<tbody id="table-verifikasi-data">
				@foreach ($data as $keyd=> $d)
				
					<tr class="{{HP::color_status_data($d->status_data,$d->daftar_draf)}}">
						<td></td>
						<td>{{$keyd+1}}</td>

						<td>{{$d->id}}</td>
						<td>{{$d->updated_at?Carbon\Carbon::parse($d->updated_at)->format('d F Y'):'-'}}</td>

						<td>{{$d->name}}</td>
						<td>{{$d->status_desa}}</td>
						<td>{{$d->nama_kecamatan}}</td>
						<td>{{$d->nama_kota}}</td>
						<td>{{$d->nama_provinsi}}</td>

						<td>{{HP::verifikasi_status($d->status_data)}}</td>
						
						@php
							$data_colm=(array)$d;
						@endphp
						@foreach ($table_map['columns'] as $key=>$c)
						
							<td>{!!$c['definisi']??'...'!!}</td>
							<td>{{HPV::nformat($data_colm[$key]??'-')}}</td>
							@php
							
								if((!isset($total[$key])) and ($c['tipe_data']=='numeric') ){
									$total[$key]=0;
								}

								if(($c['tipe_data']=='numeric')){
									if(in_array($c['aggregate_type'], ['SUM'])){
										$total[$key]+=(double)$data_colm[$key];
									}
								}



							@endphp
							{{-- expr --}}
						@endforeach




					</tr>

				@endforeach

				<tr id="tr-total" class="bg-primary">
					<td colspan="10"><b>JUMLAH TOTAL</b></td>

				@foreach ($table_map['columns'] as $key=>$c)
					@if($c['tipe_data']=='numeric')
							@if(($c['tipe_data']=='numeric'))
								@if(in_array($c['aggregate_type'], ['SUM']))
									<td></td>
									<td colspan=""><b>{{HPV::nformat($total[$key])}}</b></td>	
								@else
									<td></td>
									<td colspan=""><b>-</b></td>
								@endif
							@endif
					@else
					<td></td>
					<td colspan="">-</td>
					@endif
				@endforeach
				</tr>

				
			</tbody>
		</table>
			</div>

		@else
			<h3 class="text-center text-danger"><b>DATA TIDAK TERSEDIA</b></h3>
		@endif
	</div>
	<div class="box-footer">
		
	</div>
</div>
@endif

@stop

@section('js')
	<script type="text/javascript">

		$(function(){
			$('#table-verifikasi-data').prepend($('#tr-total').clone());
		});
		function get_form(url){
			$.ajax({
				url:url,
				headers:{
					'Authorization':'Bearer {{Auth::User()->api_token}}'
				},
				success:function(res){
					console.log(res);
					LinShowForm(res);
				},
				error:function(e){

				}
			});
		}

		function get_user_list(kode_daerah){
				$.ajax({
					url:('{{route('api.list.user.daerah',[
						'tahun'=>$GLOBALS['tahun_access'],
						'kode_daerah'=>'xxxx',
						'data'=>$nama_data,
						'daerah'=>$daerah]
						)}}').replace('xxxx',kode_daerah),
					method:'post',
					headers:{
						'Authorization':'Bearer {{Auth::User()->api_token}}'
					},
					success:function(res){
						LinShowForm(res);
					},
					error:function(e){

					}
				});
			}

	</script>

	<script type="text/javascript">
		const bc = new BroadcastChannel('build_berita_acara');

		@if((session('done_build')))
			bc.postMessage(<?=json_encode(session('done_build'))?>);
		@endif



		var time_count=new Vue({
			el:"#time_count",
			data:{
				timeleft:{{$time_count_down}},
				days:null,
				hours:null,
				minutes:null,
				seconds:null

			},
			methods:{
				time_count_down(){
						this.timeleft = this.timeleft - ((1000));
						 this.days = Math.floor(this.timeleft / (1000 * 60 * 60 * 24));
						 this.hours = Math.floor((this.timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
						this.minutes = Math.floor((this.timeleft % (1000 * 60 * 60)) / (1000 * 60));
						this.seconds = Math.floor((this.timeleft % (1000 * 60)) / 1000);

						setTimeout(function(){
							time_count.time_count_down();
						},1000);
				}
			}
		});

		if($('#time_count').html()!=undefined){
			time_count.time_count_down();
		}

		function build_berita_acara(url){
			$('#build_berita_acara form').attr('action',url);

			$('#build_berita_acara .pre').attr('href',url+'&preview=true');

			$('#build_berita_acara ').modal();

		}

		function hapus_berita_acara(url){
			$('#hapus_berita_acara form').attr('action',url);
		
			$('#hapus_berita_acara ').modal();

		}
	</script>


	@if($berita_acara['berita_acara'])
	<div class="modal fade" id="hapus_berita_acara">
		<div class="modal-dialog">
			<form action="" method="post">
				@method('DELETE')

				@csrf
				<div class="modal-content">
					<input type="hidden" name="redirect" value="{{url()->full()}}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">HAPUS BERITA ACARA {{strtoupper($nama_data)}}</h4>
				</div>
				<div class="modal-body">
					<p class="text-red">PENGHAPUSAN BERITA ACARA, HASIL BERITA ACARA TIDAK DAPAT DILIHAT KEMBALI</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				
					<button type="submit" class="btn btn-primary">SETUJU</button>
				</div>
			</div>
			</form>
		</div>
	</div>
	@endif


	@if($berita_acara['access_berita_acara'])
	<div class="modal fade" id="build_berita_acara">
		<div class="modal-dialog">
			<form action="" method="post">

				@csrf
				<div class="modal-content">
					<input type="hidden" name="redirect" value="{{url()->full()}}">
				<div class="modal-header">
					<button type="button" class="close crus" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">BUAT BERITA ACARA {{strtoupper($nama_data)}}</h4>
				</div>
				<div class="modal-body">
					<p>PASTIKAN DATA TELAH VALID!</p>
					<p class="text-red">ANDA TIDAK DI PERBOLEHKAN KEMBALI MELAKUKAN EDITING DATA SETELAH PEMBUATAN BERITA ACARA INI</p>
					<small class="text-yellow" id="submit_build_ket"></small>
				</div>
				<div class="modal-footer" >
					
					<div class="btn-group">
						<a style="display: none;" href="{{route('game.pingpong')}}" target="_blank" class="btn btn-danger hiburan">Main Game</a>
							<button type="button" class="crus btn btn-default" data-dismiss="modal">Close</button>
					
						<a target="_blank"  href=""  class="pre btn btn-info">PREVIEW</a>
						<button type="button" onclick="submit_build()" class="crus btn btn-primary">SETUJU</button>
					</div>
				
				</div>
			</div>
			</form>
		</div>
	</div>
	@endif

	<script type="text/javascript">
		function submit_build(){
			$('#submit_build_ket').html('Proses Pembuatan Berita acara memerlukan waktu yang cukup panjang tergatung jenis dan jumlah data, mohon menunggu dan tidak menuntup page atau merefresh!');
			$('#build_berita_acara .crus').css('display','none');
			$('#build_berita_acara .hiburan').css('display','block');


			$('#build_berita_acara form' ).submit();
		}
	</script>

@stop