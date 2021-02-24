@extends('vendor.adminlte.admin')
@section('content_header')
<h4>VALIDASI DATA <b>{{($daerah)?($daerah->parent.' '.$daerah->jenis.' '.$daerah->name):''}}</b></h4>
<hr style="border-color: #fff">
<div class="form-group">
	<label>DATA</label>
	<form method="get" action="{{url()->full()}}">
		<div class="row">
			<div class="col-md-6">
				<select class="form-control" name="data" onchange="$(this).parent().parent().parent().submit()">
		@foreach($table as $key=>$t)
			<option value="{{$key}}" {{$data_index==$key?'selected':''}} >{{$t['name']}}</option>
		@endforeach
		</select>
			</div>
		</div>
	</form>
</div>
<hr style="border-color: #fff">

<div class="row bg-navy" style=" padding-top: 10px;" >
	<div class="col-md-4">
		<div class="box-solid box bg-yellow">
			<div class="box-header with-border">
				<h4><b>Jumlah Data</b></h4>
			</div>
		<div class="box-body">
			<p>{{number_format($data->total())}} DESA</p>
		</div>
	</div>
	</div>
	<div class="col-md-4">
		<div class="box-solid box bg-green">
			<div class="box-header with-border">
				<h4><b>Sudah Terverifikasi Data</b></h4>
			</div>
		<div class="box-body">
			<p>{{number_format($data->total())}} DESA</p>
		</div>
	</div>
	</div>
	<div class="col-md-4">
		<div class="box-solid box bg-maroon">
			<div class="box-header with-border">
				<h4><b>Belum Terverifikasi Data</b></h4>
			</div>
		<div class="box-body">
			<p>{{number_format($data->total())}} DESA</p>
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
					@foreach($data[0] as $key=>$x)
						<th>{{str_replace('_',' ',$key)}}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr>
						@foreach($d as $x)
							<td>{{$x}}</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>
		{{$data->links()}}

		@else
			<h3 class="text-center text-danger"><b>DATA TIDAK TERSEDIA</b></h3>
		@endif
	</div>
</div>

@stop