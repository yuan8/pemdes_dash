@extends('vendor.adminlte.dashboard')

@section('content_header')
	@include('partials.banner_head')
@stop

@section('content')
<h2 class="text-center"><b>PINDAHKAN TAHUN AKSES</b></h2>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="box box-danger btn-ov">
			<form action="{{route('p.tahun.change',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
				@csrf
				<div class="box-body">
				<div class="form-group">
					<label>Pilih Tahun</label>
					<input type="hidden" name="pre" value="{{$pre}}">
					<select class="form-control" name="tahun_new">
						@foreach($tahuns as $t)
						<option value="{{$t->tahun}}" {{$GLOBALS['tahun_access']==$t->tahun?'selected':''}} >{{$t->tahun}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="box-footer">
				<button class="btn btn-danger" type="submit">Pindah</button>
			</div>
			</form>
		</div>
	</div>
</div>
@stop 
