@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TAMBAH KATEGORI FAQ</h4>
<div class="btn-group">
</div>

@stop

@section('content')
<form action="{{route('admin.faq.c.store',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
<div class="box box-solid">
	<div class="box-body">
		
		<div class="form-group">
			<label>KATEGORI</label>
			<input type="text" value="{{old('nama')}}" class="form-control" name="nama" required="">
		</div>
		<div class="form-group">
			<label>DESKRIPSI</label>
			<textarea class="form-control" id="answer" name="deskripsi" required="">{!!old('deskripsi')!!}</textarea>
		</div>


	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary"> Tambah</button>
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