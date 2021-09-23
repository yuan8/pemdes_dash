@extends('vendor.adminlte.admin')
@section('content_header')
<h4>FAQ</h4>
<div class="btn-group">
	<a href="{{route('admin.faq.c.add',['tahun'=>$GLOBALS['tahun_access']])}}" class="btn btn-success">Tambah Kategori FAQ</a>
</div>

@stop

@section('content')
<div class="box-solid box">
				<div class="box-body">
					<div class="row">
		<form action="" method="get" id="form-search">
			<div class="col-md-6">
			<label>Search</label>
			<input type="text" value="{{$req['q']??''}}" v-model="search" class="form-control" name="q" onchange="$('#form-search').submit()">
		</div>
		
		</form>

		</div>
			</div>
		</div>
	<div class="col-dm-12">
		<div class="box box-solid">
			<div class="box-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Kategori</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $key=> $d)
						
						<script type="text/javascript">
							var q=;
						</script>
						<tr>
							<td>{{$key+1}}</td>
							<td>{{$d->nama}}</td>
							<td>
								<a onclick="delete_faq('{{route('admin.faq.c.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}','{{$d->nama}}')" href="javascript:void(0)" class="btn btn-xs btn-danger">
									<i class="fa fa-trash"></i>
								</a>
								<a href="{{route('admin.faq.c.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-xs btn-warning">
									<i class="fa fa-pen"></i> Edit
								</a>
							</td>

						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="box-footer">
			</div>
		</div>
	</div>


<div class="modal fade" id="modal-id-delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="" method="post">
				@method('delete')
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Hapus Kategori FAQ</h4>
			</div>
			<div class="modal-body">
				<p id="text"></p>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button  type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>HAPUS</button>
			</div>
			</form>
		</div>
	</div>
</div>
@stop

@section('js')
	<script type="text/javascript">
		function delete_faq(link,text){
    		$('#modal-id-delete form').attr('action',link);
    		$('#modal-id-delete p#text').html('Hapus Kategori '+text);
    		$('#modal-id-delete').modal();

    	}
	</script>

@stop