@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TAMBAH KATEGORI FORUM</h4>
<div class="btn-group">
</div>

@stop

@section('content')
<form action="{{route('admin.forum.store',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
<div class="row">
	<div class="col-md-6">
		<div class="box box-solid">
	<div class="box-body">
		<div class="form-group">
			<label>CABANG DARI</label>
			<select class="form-control" name="parent_id">
				<option value="">NONE</option>
				@foreach ($cabang as $e)
					<option value="{{$e->id}}">{{$e->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label>NAMA KATEGORI</label>
			<input type="text" value="{{old('name')}}" class="form-control" name="nama" required="">
		</div>
		<div class="form-group ">
			<label>WARNA</label>
			<br>
			<input type="color" value="{{old('color_code')}}" class="" name="color_code" required="">
		</div>
		
		


	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary"> Tambah</button>
	</div>
</div>
	</div>
</div>	
</form>



@stop
@section('js')
  <script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
   <script src="{{asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
    <script>

    	

        $('#answer').ckeditor();
    </script>

@stop