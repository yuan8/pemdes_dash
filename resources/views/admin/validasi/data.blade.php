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



@php
@endphp
@if($berita_acara['berita_acara'] and in_array(Auth::User()->role,[1,2,4]) )
<iframe src="{{$berita_acara['berita_acara']}}" style="width:100%; border:none; height: 500px;" ></iframe>
@else
<div class="box box-primary">
	<div id="data-edited">
	<form id="form-save-edit" action="{{route('admin.validasi.data_update',['tahun'=>$GLOBALS['tahun_access'],
	'kode_daerah'=>$kode_daerah,'data'=>$table_map['id_map']])}}" method="post">
		@csrf

		<div v-for="(item,key) in data">
			<input type="hidden" v-bind:name="'edited['+item.id+']'" v-model="item.data" >
		</div>
		<div class="text-center" v-if="data.length>0">
		<p class="bg-maroon"><b>Anda Telah Melakukan Perubahan @{{data.length}} Data Desa</b></p>
		<button type="button" v-on:click="submit" class="btn btn-primary" >Kirim Perubahan</button>
		<hr>
		</div>
	</form>
</div>
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
		
		<h5><b>TOTAL DATA : {{HPV::nformat($paginate?$data->total():count($data))}} DATA</b></h5>
		@if(count($data)>0)

			<div class="table-responsive">
				<table class="table-bordered table" id="data-table">
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
			<tr v-for="(item,i) in data_desa" v-bind:class="build_status_text(item.status_data).color_bg">
				<td class="bg-gray">
					<button v-on:click="build_form_edit(item,i)" type="button" class="btn btn-warning btn-xs" >
						Edit
					</button>
				</td>
				<td>@{{i+1}} <i v-if="item.perubahan!=undefined" class="fa fa-check"></i></td>
				<td>@{{item.id}}</td>
				<td>@{{item.updated_at}}</td>
				<td>@{{item.name}}</td>
				<td>@{{item.status_desa}}</td>
				<td>@{{item.nama_kecamatan}}</td>
				<td>@{{item.nama_kota}}</td>
				<td>@{{item.nama_provinsi}}</td>
				<td>@{{build_status_text(item.status_data).text}}</td>

				<template v-for="(column,c) in data_column">
					<td>@{{column.definisi}}</td>

					<td>
						@{{item[c]??'-'}} 
					</td>
				</template>





			</tr>

				
			</tbody>
		</table>
			</div>

		@else
			<h3 class="text-center text-danger"><b>DATA TIDAK TERSEDIA</b></h3>
		@endif
	</div>
	<div class="box-footer">
		@if ($paginate)

			{{$data->links()}}
		@endif
	</div>
</div>
@endif

@stop

@section('js')

	<script type="text/javascript">
			unsaved=false;


		// function unloadPage(event){ 
		//     if(unsaved){
		//         return confirm("Data Perubahan Belum disimpan!. Simpan Terlebih dahulu atau abaikan pesan ini");
		//     }
		// }

		window.onbeforeunload = function(){ 
		    if(unsaved){
		        return ("Data Perubahan Belum disimpan!. Simpan Terlebih dahulu atau abaikan pesan ini");
		    }else{
		    	
		    }
		}

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



		

		if($('#time_count').html()!=undefined){
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
	@php
	@endphp

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

	<script type="text/javascript">


		window.de={};
	var vdata=new Vue({
		el:'#data-table',
		data:{
			data_desa:<?=json_encode($paginate?$data->items():$data)?>,
			data_column:<?=json_encode($table_map['columns'])?>,
			data_edit:[

			],
			edit_filed:[

			]
		}
		,
		methods:{
			build_form_edit:function(data_desa,key){
				window.de=JSON.parse(JSON.stringify(data_desa));
				window.ModalEdit.data=de;
				window.ModalEdit.key=key;
				window.ModalEdit.show();

			},
			build_status_text:function(status=null){
				switch(status){
					case 1:
					return {
						text:'Hold Data',
						color_bg:'bg-danger'
					};
					break;
					case 2:
					return {
						text:'Verifikasi Desa/Kel',
						color_bg:'bg-green'
					};
					break;
					case 3:
					return {
						text:'Verifikasi Kecamatan',
						color_bg:'bg-yellow'
					};
					break;
					case 5:
					return {
						text:'Valid',
						color_bg:''
					};
					
					break;
					default:
					return {
						text:'Integrasi Data',
						color_bg:'bg-maroon'
					};
					break;
				}
			}
		}
	});

	
</script>

<div class="modal fade" id="modal-edit">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Data @{{data.name}}</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<label>Status Data</label>
							<select class="form-control" v-model="data.status_data">
							@php
								$code_abl=array_keys(HP::abl_aksi_front());
							@endphp
							@foreach (HP::abl_aksi_front('ALL') as $code=>$l)
								<option value="{{$code}}" {{in_array($code,$code_abl)?'':"disabled"}}>{{$l}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-6">
						<div v-for="(column,i) in data_column_1">
							<div class="form-group" v-if="(column.interval_nilai.length==0)&&column.tipe_data=='numeric'">
								<label>@{{column.name}} <span ><i data-toggle="tooltip" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?" class="fa fa-info"></i></button></span></label>
								<div class="input-group">
									<input type="number" name="" class="form-control" v-model="data[i]">
									<span class="input-group-btn">
										<button type="button" class="btn btn" disabled="">@{{column.satuan}}</button>
									</span>
								</div>
							</div>
							<div class="form-group" v-if="(column.interval_nilai.length>0)">
								<label>@{{column.name}}</label>
								<div class="input-group">
									<select  name="" class="form-control" v-model="data[i]">
										<option v-bind:value="i" v-for="(v) in column.interval_nilai">@{{i}}</option>
									</select>
									<span class="input-group-btn">
										<button type="button" class="btn" disabled="">@{{column.satuan}}</button>
									</span>
								</div>
							</div>
							
						</div>
					</div>
					<div class="col-md-6">
						<div v-for="(column,i) in data_column_2">
							<div class="form-group" v-if="(column.interval_nilai.length==0)&&column.tipe_data=='numeric'">
								<label>@{{column.name}} </label>
								<div class="input-group">
									<input type="number" name="" class="form-control" v-model="data[i]">
									<span class="input-group-btn">
										<button type="button" class="btn btn" disabled="">@{{column.satuan}}</button>
									</span>
								</div>
							</div>
							<div class="form-group" v-if="(column.interval_nilai.length>0)">
								<label>@{{column.name}}</label>
								<div class="input-group">
									<select  name="" class="form-control" v-model="data[i]">
										<option v-bind:value="v" v-for="(v) in column.interval_nilai">@{{v}}</option>
									</select>
									<span class="input-group-btn">
										<button type="button" class="btn" disabled="">@{{column.satuan}}</button>
									</span>
								</div>
							</div>
							
						</div>
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button"  v-on:click="sinkronisasi" class="btn btn-primary">Simpan Perubahan</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">


	var ModalEdit=new Vue({
		el:"#modal-edit",
		data:{
			data:{},
			key:null,
			data_column:<?=json_encode($table_map['columns'])?>,
			data_column_array:<?=json_encode(array_values($table_map['columns']))?>,
			data_column_1:{},
			data_column_2:{}
		},
		methods:{
			show:function(){
				var chunk=this.data_column_array.length/2;
				if(!(chunk % 1 === 0)){
					chunk=parseInt(chunk)+1;
				}

				for (var i =0;this.data_column_array.length>i; i++) {
					this.data_column['data_'+i]['interval_nilai']=this.data_column['data_'+i]['interval_nilai']??'';
					if(this.data_column['data_'+i]['interval_nilai'].length>0){
						if(!Array.isArray(this.data_column['data_'+i]['interval_nilai'])){
						this.data_column['data_'+i]['interval_nilai']=this.data_column['data_'+i]['interval_nilai'].split('|;|');
						}
					}
					if(i<chunk){
						this.data_column_1['data_'+i]=this.data_column['data_'+i];
					}else{
						this.data_column_2['data_'+i]=this.data_column['data_'+i];
					}
				}				


				$("#modal-edit").modal();
			},
			sinkronisasi:function(){
				// window.vdata.data_desa[this.key]=this.data;
				var dataset_update={
					status_validasi:this.data.status_data
				};

				for((k) in this.data_column){
					dataset_update[this.data_column[k].name_column]=this.data[k];
					window.vdata.data_desa[this.key][k]=this.data[k];

					
				}
				window.vdata.data_desa[this.key]['status_data']=879829289;
				window.vdata.data_desa[this.key]['status_data']=parseInt(this.data.status_data);

				window.vdata.data_desa[this.key]['perubahan']=' - Terdapat Perubahan';
				
				var key_exist=null;
				for(key in window.EditedData.data){
					if(window.EditedData.data[key].id==this.data.id){
						key_exist=key;
					}else{

					}
				}

				if(key_exist){
					window.EditedData.data[key_exist]={id:this.data.id,data:JSON.stringify(dataset_update)};
				}else{
					window.EditedData.data.push({id:this.data.id,data:JSON.stringify(dataset_update)});
				}

				

				$('#modal-edit').modal('toggle');
			}

		}
	});


	var EditedData=new Vue({
		el:"#data-edited",
		data:{
			data:[
			],
			list_ajax:{}
			
		},
		methods:{
			
			submit:function(){
				window.unsaved=false;
				$('#form-save-edit').submit();
			}
		},
		watch:{
			data:function(){
				if(this.data.length>0){
					window.unsaved=true;
				}else{
					window.unsaved=false;
				}
			}
		}
	});



</script>

@stop



