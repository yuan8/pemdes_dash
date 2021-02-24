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
			<option value="TEMA_PRIMER" {{$req->jenis=='TEMA_PRIMER'?'selected':''}}>TEMA DATA UTAMA</option>
			<option value="TEMA_SEKUNDER" {{$req->jenis=='TEMA_SEKUNDER'?'selected':''}}>DATA DATA PENDUKUNG</option>
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
						<td>{{str_replace('_',' ',$d->type)}}</td>
						<td><img style="width:20px;" src="{{asset($d->image_path)}}"></td>
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
