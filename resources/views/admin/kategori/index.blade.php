@extends('vendor.adminlte.admin')
@section('content_header')
<h4>KATEGORI</h4>
<div class="btn-group">
<a href="{{route('admin.kategori.create')}}" class="btn btn-primary">TAMBAH</a>
	
</div>
@stop


@section('content')

<div class="box box-solid">
	<div class="box-header">
		<form action="{{route('admin.kategori.index')}}" method="get">
		<select class="form-control" name="jenis" onchange="$(this).parent().submit()">
			<option value="PRIMER_" {{$req->jenis=='PRIMER_'?'selected':''}}>KATEGORI PRIMER</option>
			<option value="SEKUNDER_" {{$req->jenis=='SEKUNDER_'?'selected':''}}>KATEGORI PENDUKUNG</option>
		</select>
			
		</form>
	</div>
	<div class="box-body">
		<table class="table-bordered table" id="table-id">
			<thead>
				<tr>
					<th>AKSI</th>
					<th>NO.</th>
					<th>JENIS</th>
					<th>IMAGE</th>
					<th>NAMA</th>
					<th>ROUTE ACCESS</th>
					<th>DESKRIPSI</th>

				</tr>
			</thead>
			<tbody>
				@foreach($data as $key=>$d)
					<tr>
						<td></td>
						<td>{{$key+1}}</td>
						<td>{{strreplace('_',' ',$$d->type)}}</td>
						<td><img src="{{asset($d->image_path)}}"></td>
						<td>{{$d->name}}</td>
						<td>{{$d->route}}</td>
						<td>{{$d->description}}</td>

					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@stop

@section('js')
<script type="text/javascript">
	$('#table-id').dataTable({
		'pageLength':false,
		'lengthChange':false,
		'ordering':false,
		'paging':false


	});
</script>




@stop
