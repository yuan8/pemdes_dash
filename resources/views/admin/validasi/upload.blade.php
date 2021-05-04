@extends('vendor.adminlte.admin')
@section('content_header')
<h4>{{$level['data_name']}}</h4>
@php
@endphp
<h4>{{$GLOBALS['tahun_access']}} -  {{$daerah}}</b></h4>

@stop

@section('content')
<div class="row">
	<div class="col-md-6">
		<form action="{{route('admin.validasi.update.bulk',['tahun'=>$GLOBALS['tahun_access'],'id'=>$table->id])}}" enctype='multipart/form-data' method="post">
		<div class="box-primary box">
	<div class="box-body">
		<div class="form-group">
			<input type="hidden" name="kd" value="{{$kd}}">
			<input type="hidden" name="id_table" value="{{$table->id}}">

			<label>File Format Upload </label>
			<input type="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="file" required="">
		</div>
	</div>
	<div class="box-footer">
		<button class="btn btn-primary">Upload</button>
	</div>
	</div>
</form>
	</div>
</div>

@stop