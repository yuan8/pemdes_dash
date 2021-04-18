@extends('vendor.adminlte.admin')
@section('content_header')
<h4>VALIDASI DATA - {{$nama_daerah}}</h4>
@stop


@section('content')
	<form method="get" action="{{route('admin.validasi.data',['tahun'=>$GLOBALS['tahun_access']])}}">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<input type="hidden" name="kdprovinsi" value="{{$provinsi}}">
					<input type="hidden" name="kdkabkota" value="{{$kodedaerah}}">

					<label>DATA</label>

					<select class="form-control" name="data" id="data" required="">
						@foreach($table as $key=>$t)
							<option value="{{$t->id}}">{{$t->name}}</option>
						@endforeach
					</select>
				</div>
				<button class="btn btn-primary">SUBMIT</button>
				<script type="text/javascript">
					$('#data').select2()
				</script>
			</div>

		</div>
	</form>
	@stop