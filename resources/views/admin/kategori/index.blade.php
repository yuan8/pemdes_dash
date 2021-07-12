@extends('vendor.adminlte.admin')
@section('content_header')
<h4>KATEGORI</h4>
<div class="btn-group">
<a href="{{route('admin.kategori.create',['tahun'=>$GLOBALS['tahun_access']])}}" class="btn btn-success">TAMBAH KATEGORI</a>
	
</div>
@stop


@section('content')

<div class="box box-solid">
	<div class="box-header">
		<form action="{{route('admin.kategori.index',['tahun'=>$GLOBALS['tahun_access']])}}" method="get">
		<select class="form-control" name="jenis" onchange="$(this).parent().submit()">
			<option value="TEMA_DATA_UTAMA" {{$req->jenis=='TEMA_DATA_UTAMA'?'selected':''}}>TEMA DATA UTAMA</option>
			<option value="TEMA_DATA_PENDUKUNG" {{$req->jenis=='TEMA_DATA_PENDUKUNG'?'selected':''}}>DATA DATA PENDUKUNG</option>
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
					{{-- <th>ROUTE ACCESS</th> --}}
					<th>DESKRIPSI</th>

				</tr>
			</thead>
			<tbody>
				@foreach($data as $key=>$d)
					<tr>
						<td>
							<a href="{{route('admin.kategori.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> Edit</a>
							<a href="{{route('admin.kategori.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </a>
							
						</td>
						<td>{{$key+1}}</td>
						<td>{{str_replace('_',' ',$d->type)}}</td>
						<td><img style="width:20px;" src="{{asset($d->image_path)}}"></td>
						<td>{{$d->name}}</td>
						{{-- <td>{{$d->route}}</td> --}}
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
