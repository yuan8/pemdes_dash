@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TAMBAH TABLE MAP</h4>

@stop


@section('content')
<form action="{{route('admin.tablemap.store',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
	@csrf
	<div class="box box-primary">
		<div class="box-body">
			<div class="form-group">
				<label>Nama</label>
				<input type="text" class="form-control" name="name" required="">
			</div>
			<div class="form-group">
				<label>Key Table</label>
				<input type="text" class="form-control" name="key_view"   required="">
			</div>
			<div class="form-group">
				<label>Table</label>
				<input type="text" class="form-control" name="table"  required="">
			</div>
			<div class="form-group">
				<label>Gunakan Sebagai Format Data Validasi</label>
				<p><input type="radio" value="1"  name="format_validasi" > Ya</p>
				<p><input type="radio" value="0"  name="format_validasi" checked=""> Tidak</p>

			</div>
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary">TAMBAH</button>
		</div>
	</div>
</form>

@stop