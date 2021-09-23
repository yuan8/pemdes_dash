@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TAMBAH FAQ</h4>
<div class="btn-group">
</div>

@stop

@section('content')
<form action="{{route('admin.faq.store',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
<div class="box box-solid">
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
			<label>Kategory</label>
			<select class="form-control" name="category">
				@foreach ($category as $c)
					{{-- expr --}}
					<option value="{{$c->id}}" {{old('category')?(old('category')==$c->id?'selected':''):null}} >
						{{$c->nama}}
						</option>
						}
				@endforeach
			</select>
		</div>
			</div>
		</div>
		<div class="form-group">
			<label>Pertanyaan</label>
			<input type="text" value="{{old('question')}}" class="form-control" name="question" required="">
		</div>
		<div class="form-group">
			<label>Jawaban</label>
			<textarea class="form-control" id="answer" name="answer" required="">{!!old('answer')!!}</textarea>
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