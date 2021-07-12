@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TAMBAH REGIONAL</h4>
@stop


@section('content')
<form action="{{route('admin.region.store',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
	@csrf
	<div class="box box-solid">
	<div class="box-hedaer with-border">
		
	</div>
	<div class="box-body">
		<div class="form-group">
			<label>Nama</label>	
			<input type="text" name="name" class="form-control" required="" value="">
		</div>
		<div class="form-group">
			<label>List Daerah</label>	
			<select class="form-control" required="" name="anggota[]" multiple="" id="list">
				@foreach ($daerah as $d)
					<option value="{{$d->id}}" >{{$d->text}}</option>	
				@endforeach
			</select>
		</div>
		<script type="text/javascript">
			$('#list').select2();
		</script>
	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary">TAMBAH</button>
	</div>
</div>
</form>

@stop

@section('js')
<script type="text/javascript">
	
</script>
@stop
