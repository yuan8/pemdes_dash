@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TABLE [{{$data->key_view}}]</h4>
<h5>{{$data->name}}</h5>

@stop


@section('content')
<form action="{{route('admin.tablemap.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="post">
	@csrf
	@method('PUT')
	<div class="box box-primary">
		<div class="box-body">
			<div class="form-group">
				<label>Nama</label>
				<input type="text" class="form-control" name="name" value="{{$data->name}}" required="">
			</div>
			<div class="form-group">
				<label>Key Table</label>
				<input type="text" class="form-control" name="key_view"  value="{{$data->key_view}}" required="">
			</div>
			<div class="form-group">
				<label>Table</label>
				<input type="text" class="form-control" name="table" value="{{$data->table}}" required="">
			</div>
			<div class="form-group">
				<label>Gunakan Sebagai Format Data Validasi</label>
				<p><input type="radio" value="1" name="format_validasi" {{($data->edit_daerah==1)?'checked':''}} > Ya</p>
				<p><input type="radio" value="0" name="format_validasi"  {{(0==$data->edit_daerah)?'checked':''}} > Tidak</p>

			</div>
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary">UPDATE</button>
		</div>
	</div>
</form>

@stop