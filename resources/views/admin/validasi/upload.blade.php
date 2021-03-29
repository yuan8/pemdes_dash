@extends('vendor.adminlte.admin')
@section('content_header')
<h4>{{$table->name}}</h4>
<h4>{{$GLOBALS['tahun_access']}} - UPLOAD BULK VALIDASI DATA <b>{{($daerah)?($daerah->parent.' '.$daerah->jenis.' '.$daerah->name):''}}</b></h4>

@stop

@section('content')
<div class="row">
	<div class="col-md-6">
		<form action="{{route('admin.validasi.update.bulk',['tahun'=>$GLOBALS['tahun_access'],'id'=>$table->id])}}" enctype='multipart/form-data' method="post">
		<div class="box-primary box">
	<div class="box-body">
		<div class="form-group">
			<input type="hidden" name="kd" value="{{$kd}}">
			<input type="hidden" name="table" value="{{$table->table}}">

			<label>File Format Upload Validasi</label>
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