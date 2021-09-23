@extends('vendor.adminlte.admin')
@section('content_header')
<h4>FAQ</h4>
<div class="btn-group">
	<a href="{{route('admin.faq.create',['tahun'=>$GLOBALS['tahun_access']])}}" class="btn btn-success">Tambah FAQ</a>
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
		<div class="col-md-6">
			<label>Kategory</label>
			<select class="form-control" name="category" onchange="$('#form-search').submit()">
				<option value="">-</option>
				@foreach ($category as $c)
					<option value="{{$c->id}}" {{$c->id==($req['category']??'')}}>{{$c->nama}}</option>
				@endforeach
			</select>
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
							<th>Kategory</th>
							<th>Pertanyaan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $d)
						
						<script type="text/javascript">
							var q=;
						</script>
						<tr>
							<td>{{$d->cat_nama}}</td>
							<td>{{$d->question}}</td>
							<td>
								<a onclick="delete_faq('{{route('admin.faq.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}','{{$d->question}}')" href="javascript:void(0)" class="btn btn-xs btn-danger">
									<i class="fa fa-trash"></i>
								</a>
								<a href="{{route('admin.faq.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-xs btn-warning">
									<i class="fa fa-pen"></i> Edit
								</a>
							</td>

						</tr>
							{{-- expr --}}
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="box-footer">
				{{$data->links()}}
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
				<h4 class="modal-title">Hapus FAQ</h4>
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
    		$('#modal-id-delete p#text').html('Hapus '+text);
    		$('#modal-id-delete').modal();

    	}
	</script>

@stop