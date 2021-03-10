@extends('vendor.adminlte.admin')
@section('content_header')
<h4>{{$GLOBALS['tahun_access']}} - VALIDASI DATA <b>{{($daerah)?($daerah->parent.' '.$daerah->jenis.' '.$daerah->name):''}}</b></h4>
<hr style="border-color: #fff">
<div class="form-group">
	<label>DATA</label>
	<form method="get" action="{{url()->full()}}">
		<div class="row">
		<div class="col-md-6">
			@foreach($req as $keyr=>$r)
				<input type="hidden" name="{{$keyr}}" value="{{$r}}">
			@endforeach
			<select class="form-control" name="data"  id="data" onchange="$(this).parent().parent().parent().submit()">
				@foreach($table as $key=>$t)
					<option value="{{$t->id}}" {{$data_index==$t->id?'selected':''}}>{{$t->name}}</option>
				@endforeach
		</select>
			</div>
		</div>
	</form>

	<script type="text/javascript">
		$('#data').select2();
	</script>
</div>
<hr style="border-color: #fff">

<div class="row bg-navy" style=" padding-top: 10px;" >
	<div class="col-md-4">
		<div class="box-solid box bg-yellow">
			<div class="box-header with-border">
				<h4><b>Jumlah Data</b></h4>
			</div>
		<div class="box-body">
			<p>{{HPV::nformat($data->total())}} DESA</p>
		</div>
	</div>
	</div>
	<div class="col-md-4">
		<div class="box-solid box bg-green">
			<div class="box-header with-border">
				<h4><b>Data Sudah Valid </b></h4>
			</div>
		<div class="box-body">
			<p>{{HPV::nformat($rekap['sudah'])}} DESA</p>
		</div>
	</div>
	</div>
	<div class="col-md-4">
		<div class="box-solid box bg-maroon">
			<div class="box-header with-border">
				<h4><b>Data Belum Valid</b></h4>
			</div>
		<div class="box-body">
			<p>{{HPV::nformat($rekap['belum'])}} DESA</p>
		</div>
	</div>
	</div>
	<div class="col-md-12">
		<h5>BULK VALIDASI</h5>
		<div class="btn-group">
		
			<a href="{{url()->full().'&export_format=true'}}" download="" class="btn btn-primary"> Download Excel Format</button>
			<a href="{{route('admin.validasi.upload',['tahun'=>$GLOBALS['tahun_access'],'kdprovinsi'=>$req['kdprovinsi'],'kdkota'=>$req['kdkota'],'kdkecamatan'=>$req['kdkecamatan'],'kddesa'=>$req['kddesa'],'data'=>$req['data']])}}" class="btn btn-success ">Upload Data</a>
		</div>
	</div>
</div>


@stop


@section('content')

<div class="box box-primary">
	<div class="box-header with-border">
		<h4><b>{{$table_map['name']}}</b></h4>
	</div>
	<div class="box-body table-responsive">
		@if(count($data)>0)
			<table class="table-bordered table">
			<thead>
				<tr>
					<th style="width:80px;">AKSI</th>
					@foreach(HPV::maping_row($data,$table_map)[0] as $key=>$x)
						@php
						@endphp
						<th>{{strtoupper($x['name']).' '.($x['aggregate_type']!='NONE'?'('.$x['aggregate_type'].')':'')}} {{$x['satuan']?' - '.$x['satuan']:""}}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach(HPV::maping_row($data,$table_map) as $d)
				
					<tr class="{{$d['status_validasi']['value']=='VALID'?'bg-success':'bg-waning'}}">
						<td>
							<div class="btn-group">
								<button class="btn btn-xs btn-primary" onclick="get_form('{{route('api.data.validate.form',['tahun'=>$GLOBALS['tahun_access'],'table'=>$table_map['key_view'],'id'=>$d['id_desa']['value']])}}')"><i class="fa fa-check"></i></button>

								<button class="btn btn-xs btn-warning"><i class="fa fa-pen"></i></button>
							</div>
						</td>
						@foreach($d as $kk=> $x)
							<td>{{HPV::nformat($x['value'],$kk)}}</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>

		@else
			<h3 class="text-center text-danger"><b>DATA TIDAK TERSEDIA</b></h3>
		@endif
	</div>
	<div class="box-footer">
		{{$data->links()}}
		
	</div>
</div>

@stop

@section('js')
	<script type="text/javascript">
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

	</script>
@stop