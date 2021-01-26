@extends('vendor.adminlte.admin')
@section('content_header')
<h4>KATEGORI</h4>
<div class="btn-group">
<button class="btn btn-primary">TAMBAH</button>
	
</div>
@stop


@section('content')

<div class="box box-solid">
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
		'lengthPage':false,
	});
</script>




@stop
