@extends('vendor.adminlte.admin')
@section('content_header')
<h4>{{$GLOBALS['tahun_access']}} - VALIDASI DATA <b>{{($daerah)}}</b></h4>
<hr style="border-color: #fff">
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
				<h4 class="text-capitalize"><b>Terverifikasi {{strtolower(HP::verifikasi_status_level($kode_daerah)['level'])}} </b></h4>
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
			@php
				$berita_acara=HP::berita_acara($kode_daerah,$GLOBALS['tahun_access'],$table_map['id_map']);
			@endphp
			@if($berita_acara['access'])
				@if($berita_acara['berita_acara'])
					<a href="" class="btn btn-primary">DOWNLOAD DATA</a>
				@else
					<a href="{{ route('admin.validasi.berita_acara.build',array_merge(['tahun'=>$GLOBALS['tahun_access'],'kdkabkota'=>$req['kdkabkota'],'data'=>$req['data']])) }}" class="btn btn-danger">BUAT BERITA ACARA</a>
					<a href="{{url()->full().'&export_format=true'}}" download="" class="btn btn-primary"> DOWNLOAD FORM</a>
					<a href="{{route('admin.validasi.upload',['tahun'=>$GLOBALS['tahun_access'],'kdprovinsi'=>$req['kdprovinsi'],'kdkabkota'=>$req['kdkabkota'],'kdkecamatan'=>$req['kdkecamatan'],'kddesa'=>$req['kddesa'],'data'=>$req['data']])}}" class="btn btn-success ">UPLOAD DATA PERUBAHAN</a>
				@endif
			@elseif($berita_acara['access_form'])
				<a href="{{url()->full().'&export_format=true'}}" download="" class="btn btn-primary"> DOWNLOAD FORM</a>
					<a href="{{route('admin.validasi.upload',['tahun'=>$GLOBALS['tahun_access'],'kdprovinsi'=>$req['kdprovinsi'],'kdkabkota'=>$req['kdkabkota'],'kdkecamatan'=>$req['kdkecamatan'],'kddesa'=>$req['kddesa'],'data'=>$req['data']])}}" class="btn btn-success ">UPLOAD DATA PERUBAHAN</a>
			@endif
	
			
			

			
		</div>
	</div>
</div>


@stop


@section('content')

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
						<select class="form-control" name="verifikasi_status" onchange="$(this).parent().parent().parent().parent().submit()">
							<option value="">SEMUA</option>
							@foreach (HP::verifikasi_list() as $vl)

								<option value="{{$vl['id']}}" {{$vl['id']==$req['verifikasi_status']?'selected':''}}>{{$vl['text']}}</option>
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
		@if(count($data)>0)

			<div class="table-responsive">
				<table class="table-bordered table">
			<thead>
				<tr>
					<th rowspan="2" style="width:80px;">AKSI</th>
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
				@foreach ($data as $d)
					<tr>
						<td></td>
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

								if(($c['tipe_data']='numeric')){
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
					<td colspan="8"><b>JUMLAH TOTAL</b></td>

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
@stop