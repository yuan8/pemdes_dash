@extends('vendor.adminlte.admin')
@section('content_header')
<h4>SETTING</h4>
@stop


@section('content')
	<div class="box">
		<form action="{{route('admin.setting.update',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
			<div class="box-header with-border">
			@foreach ($map as $key=>$el)
				<a href="{{route('admin.setting.index',['tahun'=>$GLOBALS['tahun_access'],'menu'=>$key])}}" class="btn {{$menu==$key?'btn-primary':'btn-default'}}">{{strtoupper(str_replace('_', ' ', $key))}}</a>
			@endforeach
		</div>
		<div class="box-body">
			@foreach ($data as $key=>$d)
				<div class="form-group">
					<label>{{strtoupper(str_replace('_',' ',explode('.',$key)[1]))}}</label>
				@switch($d['type_field'])
				    @case('richtext')
				        <textarea name="{{str_replace('.','-----',$key)}}" class="form-control">{!!$d['content']!!}</textarea>
				    @break
				    @case('input_string')
				        <input name="{{str_replace('.','-----',$key)}}" class="form-control" value="{!!$d['content']!!}">
				    @break
				
				    @default
				@endswitch
				</div>
				
			@endforeach
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>

		</form>
	</div>
@stop