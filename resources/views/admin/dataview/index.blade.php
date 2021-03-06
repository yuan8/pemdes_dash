@extends('vendor.adminlte.admin')
@section('content_header')
<h4>DATA VIEW</h4>
<div class="btn-group">
<a href="{{route('admin.data.create',['tahun'=>$GLOBALS['tahun_access'],'type'=>'VISUALISASI'])}}" class="btn btn-success">TAMBAH DATA VIEW</a>


</div>
<hr style="background: #fff; border-color: #fff;">
<form method="get">
	<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>TEMA</label>
			<select class="form-control" id="tema" name="tema">
				<option value="">SEMUA</option>
				<option value="TEMA_DATA_UTAMA" {{$request->tema=='TEMA_DATA_UTAMA'?'selected':''}}>TEMA UTAMA</option>
				<option value="TEMA_DATA_PENDUKUNG" {{$request->tema=='TEMA_DATA_PENDUKUNG'?'selected':''}}>TEMA PENDUKUNG</option>
			</select>
		</div>


	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>KATEGORI</label>
			<select class="form-control" id="kategori" name="kategori">
			</select>
		</div>

		
	</div>
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
					<th>JUDUL</th>
					<th>TABLE MAP</th>
					<th>TEMA</th>
					<th>KETEGORI</th>
					<th>INSTANSI</th>

					<th>DESKRIPSI</th>

				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr>
						<td>
							<a href="{{route('get.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'slug'=>HPV::slugify($d->name)])}}" target="_blank" class="btn btn-xs btn-info"> <i class="fa fa-eye"></i> </a>
							<a href="{{route('admin.dataview.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-xs btn-warning"> <i class="fa fa-pen"></i> </a>
							<a href="" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i> </a>

						</td>
						<td>{{$d->name}}</td>
						<td>{{$d->table_view}}</td>


						<td>{{str_replace('_',' ',$d->tema)}}</td>

						<td>{{$d->nama_category}}</td>
						<td>{{$d->instansi}}</td>

						<td>{{$d->description}}</td>

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