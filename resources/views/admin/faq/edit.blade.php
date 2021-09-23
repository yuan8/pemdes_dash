@extends('vendor.adminlte.admin')
@section('content_header')
<h4>FAQ</h4>
<div class="btn-group">
</div>

@stop

@section('content')
<form action="{{route('admin.faq.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="post">
@method('PUT')
<div class="box box-solid">
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
			<label>Kategory</label>
			<select class="form-control" name="category">
				@foreach ($category as $c)
					{{-- expr --}}
					<option value="{{$c->id}}" {{$data->id_category==$c->id?'selected':''}}>
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
			<input type="text" value="{{$data->question}}" class="form-control" name="question" required="">
		</div>
		<div class="form-group">
			<label>Jawaban</label>
			<textarea class="form-control" id="answer" name="answer" required="">{!!$data->answer!!}</textarea>
		</div>


	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary"> Update</button>
	</div>
</div>	
</form>



@stop
@section('js')
  <script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
   <script src="{{asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
    <script>

    	function delete_faq(link,text){
    		$('#modal-id-delete form').attr('action',link);
    		$('#modal-id-delete p#text').html(text.question);
    	}

        $('#answer').ckeditor();
    </script>

@stop