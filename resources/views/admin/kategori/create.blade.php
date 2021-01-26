@extends('vendor.adminlte.admin')

@section('content_header')
<h4>TAMBAH KATEGORI</h4>
@stop
@section('content')
	<div class="box-solid box">
		<form action="{{route('admin.kategori.store')}}" method="post" enctype='multipart/form-data'>
			@csrf
			<div class="box-body">
			<div class="form-group">
				<label>JENIS</label>
				<select class="form-control" name="jenis" required="">
						<option value="PRIMER_" {{old('jenis')=='PRIMER_'?'selected':''}}>KATEGORI PRIMER</option>
						<option value="SEKUNDER_" {{old('jenis')=='SEKUNDER_'?'selected':''}}>KATEGORI PENDUKUNG</option>
					</select>
				</select>

			</div>
			<div class="form-group">
				<label>NAMA</label>
				<input type="text" class="form-control" name="name" required="">

			</div>


			<div class="form-group">
				<label>DESKRIPSI</label>
				<textarea class="form-control" name="description"></textarea>
			</div>
			<div class="form-group">
				<label>ROUTE</label>
				<input type="text" class="form-control" name="route" required="">
			</div>
			<div class="form-group">
				<label>IMAGE</label>
				<input type="file" accept="image/png" name="image_path" required="">
			</div>
		</div>
		<div class="box-footer">
			<button class="btn btn-primary">SUBMIT</button>
		</div>
		</form>


	</div>
@stop

@section('js')





@stop
