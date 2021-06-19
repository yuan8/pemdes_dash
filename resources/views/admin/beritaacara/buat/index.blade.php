@extends('vendor.adminlte.admin')
@section('content_header')
<h4>BUAT DATA BERITA ACARA </h4>
@stop


@section('content')
	<form method="get" action="{{route('admin.validasi.data',['tahun'=>$GLOBALS['tahun_access']])}}">
		<div class="form-group">
			<label>JENIS DATA</label>
		<select class="form-control" name="jenis_data" id="jenis_data" multiple="">
			@foreach ($jenis_data as $d)
				<option value="{{$d->id}}">{{$d->name}}</option>
			@endforeach
		</select>
		</div>

		<div class="form-group">
			<label>KECAMATAN</label>
		<select class="form-control" name="kecamatan" id="kecamatan" multiple="">
			@foreach ($kecamatan as $d)
				<option value="{{$d->kdkecamatan}}">{{$d->name}}</option>
			@endforeach
		</select>
		</div>
	</form>
@stop

@section('js')
<script type="text/javascript">
	$('#jenis_data').select2();
	$('#kecamatan').select2();

</script>
@stop
