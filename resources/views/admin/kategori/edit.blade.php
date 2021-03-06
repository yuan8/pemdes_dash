@extends('vendor.adminlte.admin')

@section('content_header')
<h4>EDIT KATEGORI</h4>
@stop
@section('content')
	<div class="box-solid box">
		<form action="{{route('admin.kategori.update',['id'=>$data->id])}}" method="post" enctype='multipart/form-data'>
			@csrf
			<div class="box-body">
			<div class="form-group">
				<label>JENIS</label>
				<select class="form-control" name="jenis" required="">
						<option value="TEMA_DATA_UTAMA" {{$data->type=='TEMA_DATA_UTAMA'?'selected':''}}>KATEGORI UTAMA</option>
						<option value="TEMA_DATA_PENDUKUNG" {{$data->type=='TEMA_DATA_PENDUKUNG'?'selected':''}}>KATEGORI PENDUKUNG</option>
					</select>
				</select>

			</div>
			<div class="form-group">
				<label>NAMA</label>
				<input type="text" class="form-control" name="name" required="" value="{{$data->name}}">

			</div>

			<div class="form-group">
				<label>DESKRIPSI</label>
				<textarea class="form-control" name="description">{!!$data->description!!}</textarea>
			</div>

			<div class="form-group">
				<label>ROUTE</label>
				<input type="text" class="form-control" name="route" value="{{$data->route}}">
			</div>
			
			<div class="form-group">
				<label>IMAGE</label>
				<input type="file" accept="image/png" name="image_path" >
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
