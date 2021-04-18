@extends('vendor.adminlte.admin')
@section('content_header')
<h4>EDIT {{$data->name}}</h4>
@stop


@section('content')
<form action="{{route('admin.region.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="post">
	@csrf
	<div class="box box-solid">
	<div class="box-hedaer with-border">
		
	</div>
	<div class="box-body">
		<div class="form-group">
			<label>Nama</label>	
			<input type="text" name="name" class="form-control" required="" value="{{$data->name}}">
		</div>
		<div class="form-group">
			<label>List Daerah</label>	
			<select class="form-control" required="" name="anggota[]" multiple="" id="list">
				@foreach ($daerah as $d)
					<option value="{{$d->id}}" {{in_array($d->id,$data_req)?'selected':''}}>{{$d->text}}</option>	
				@endforeach
			</select>
		</div>
		<script type="text/javascript">
			$('#list').select2();
		</script>
	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary">UPDATE</button>
	</div>
</div>
</form>

@stop

@section('js')
<script type="text/javascript">
	
</script>
@stop
