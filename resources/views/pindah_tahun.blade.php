@extends('vendor.adminlte.dashboard')

@section('content_header')
	@include('partials.banner_head')
@stop

@section('content')
<h2 class="text-center"><b>PINDAHKAN TAHUN AKSES</b></h2>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="box box-danger btn-ov">
			<div class="box-body">
				<div class="form-group">
					<label>Pilih Tahun</label>
					<select class="form-control">
						@foreach($tahuns as $t)
						<option value="{{$t->tahun}}" >{{$t->tahun}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
@stop 
