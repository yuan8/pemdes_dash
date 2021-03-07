@extends('vendor.adminlte.admin')
@section('content_header')
<h4>TABLE MAP</h4>
<div class="btn-group">
<a href="{{route('admin.tablemap.create',['tahun'=>$GLOBALS['tahun_access']])}}" class="btn btn-success">TAMBAH TABLE MAP</a>

</div>
<hr style="background: #fff; border-color: #fff;">
<form method="get">
	<div class="row">
	

	
	<div class="col-md-12">
		<input type="text" class="form-control" name="q" value="{{$request->q}}" placeholder="Search..">
	</div>

	
	<div class="col-md-2" style="margin-top: 10px;">
		<div class="btn-group">
		<button type="submit" class="btn btn-success">Filter</button>
	</div>
	</div>
</div>
	
</form>
@stop


@section('content')
<div class="box box-primary">
	<div class="box-body">
		<table class="table-bordered table">
			<thead>
				<tr>
					<th>AKSI</th>
					<th>NAMA</th>

					<th>KEY MAP</th>
					<th>TABLE</th>
					<th>FORMAT VALIDASI</th>

					<th>JUMLAH DATA MAP COLUMN</th>

				

				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
				@php
				@endphp
					<tr>
						<td>
							
							<a href="{{route('admin.tablemap.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-xs btn-warning"> <i class="fa fa-pen"></i> </a>
							<a href="{{route('admin.tablemap.edit.view',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'slug'=>HPV::slugify($d->name)])}}"  class="btn btn-xs btn-info"> <i class="fa fa-pen"></i> VIEW</a>
							<a href="{{route('admin.tablemap.edit.columns',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'slug'=>HPV::slugify($d->name)])}}"  class="btn btn-xs btn-info"> <i class="fa fa-pen"></i> COLUMNS</a>
							<button onclick="showForm('{{route('admin.tablemap.form_delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')"  class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i> </button>

						</td>
						<td>{{$d->name}}</td>

						<td>{{$d->key_view}}</td>
						<td>{{$d->table}}</td>
						<td>{{$d->edit_daerah?'YA':'TIDAK'}}</td>

						<td>{{HPV::nformat($d->count_column)}}</td>

						

					</tr>
				@endforeach

			</tbody>
		</table>
		{{$data->links()}}
	</div>
</div>
@stop

@section('js')
<script type="text/javascript">



	function ketegori(){
		$('#kategori').val(null).trigger('change');
			$('#kategori').select2({
				'ajax':{
					'url':'{{route('api.meta.kategori')}}?tema='+$('#tema').val(),
					headers:{
						'Authorization':'Bearer {{Auth::User()->api_token}}',
						 "Content-Type" : "application/json",
					},
					data: function (term, page) {
			            return {
			                q: term.term,
			                tema:$('#tema').val()
			            };
			        },
			        results: function (data, page) {
			            console.log(data);
			            return {
			                results: data.itemName,
			                more: more
			            };
			        }
				}
			})


	}

	$('#kategori').select2();
	$('#tema').select2();
	$('#tema').on('change',function(){
		ketegori();
	});





	$('#jenis').select2();


	@if($request->kategori)
		$('#kategori').html('<option selected value="{{$request->kategori}}}">{{$pilih_kategori}}</option>').trigger('change');
	@endif

	$('#tema').trigger('change');




</script>

@stop