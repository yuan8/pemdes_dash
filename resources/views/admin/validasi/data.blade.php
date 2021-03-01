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
			<option value="{{$key}}" {{$data_index==$key?'selected':''}} >{{$t['name']}}</option>
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
				<h4><b>Sudah Terverifikasi Data</b></h4>
			</div>
		<div class="box-body">
			<p>{{HPV::nformat($rekap['sudah'])}} DESA</p>
		</div>
	</div>
	</div>
	<div class="col-md-4">
		<div class="box-solid box bg-maroon">
			<div class="box-header with-border">
				<h4><b>Belum Terverifikasi Data</b></h4>
			</div>
		<div class="box-body">
			<p>{{HPV::nformat($rekap['belum'])}} DESA</p>
		</div>
	</div>
	</div>
</div>


@stop


@section('content')

<div class="box box-primary">
	<div class="box-header with-border">
		<h4><b>{{$table[$data_index]['name']}}</b></h4>
	</div>
	<div class="box-body table-responsive">
		@if(count($data)>0)
			<table class="table-bordered table">
			<thead>
				<tr>
					<th>AKSI</th>
					@foreach($data[0] as $key=>$x)
						@if(HPV::vdata($key))
							<th>{{str_replace('_',' ',$key)}}</th>
						@endif
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr class="{{$d->Status_Verifikasi_Data=='Belum Divalidasi'?'bg-warning':'bg-success'}}">
						<td>
							<div class="btn-group">
								<button class="btn btn-xs btn-primary" onclick="get_form('{{route('api.data.validate.form',['tahun'=>$GLOBALS['tahun_access'],'table'=>$table[$data_index]['table'],'id'=>$d->kode_desa])}}')"><i class="fa fa-check"></i></button>

								<button class="btn btn-xs btn-warning"><i class="fa fa-pen"></i></button>
							</div>
						</td>
						@foreach($d as $kk=> $x)
							@if(HPV::vdata($kk))
								<td>{{HPV::nformat($x,$kk)}}</td>
							@endif
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