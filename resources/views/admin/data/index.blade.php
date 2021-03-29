@extends('vendor.adminlte.admin')
@section('content_header')
<h4>DATA</h4>
<div class="btn-group">
<a href="{{route('admin.data.create',['tahun'=>$GLOBALS['tahun_access'],'type'=>'VISUALISASI'])}}" class="btn btn-success">TAMBAH DATA VISUALISASI</a>

<a href="{{route('admin.data.create',['tahun'=>$GLOBALS['tahun_access'],'type'=>'INFOGRAFIS'])}}" class="btn btn-success">TAMBAH DATA INFOGRAFIS</a>

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

	<div class="col-md-4">
		<div class="form-group">
			<label>JENIS</label>
			<select class="form-control" id="jenis" name="jenis">
				<option value="">SEMUA</option>
				<option value="VISUALISASI" {{$request->jenis=='VISUALISASI'?'selected':''}} >VISUALISASI</option>
				<option value="DATASET"  {{$request->jenis=='DATASET'?'selected':''}}>DATASET</option>
				<option value="INFOGRAFIS"  {{$request->jenis=='INFOGRAFIS'?'selected':''}}>INFOGRAFIS</option>


			</select>
		</div>

		
	</div>
	<div class="col-md-2">
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
					<th>JENIS</th>
					<th>TEMA</th>
					<th>KETEGORI</th>
					<th>JUDUL</th>
					<th>DESKRIPSI</th>

				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr>
						<td>
							<a href="{{route('query.data.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'slug'=>HPV::slugify($d->name)])}}" class="btn btn-xs btn-info"> <i class="fa fa-eye"></i> </a>
							<a href="{{route('admin.dataset.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-xs btn-warning"> <i class="fa fa-pen"></i> </a>
							<button onclick="showForm('{{route('admin.dataview.form_delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i> </buttom>

						</td>
						<td>{{$d->delivery_type}}</td>
						<td>{{str_replace('_',' ',$d->tema)}}</td>

						<td>{{$d->nama_category}}</td>
						<td>{{$d->name}}</td>
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
		if($('#tema').val()){
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


	}

	$('#kategori').select2();
	$('#tema').select2();
	$('#tema').on('change',function(){
		ketegori();
	});

	$('#tema').trigger('change');




	$('#jenis').select2();


	@if($request->kategori)
		$('#kategori').html('<option selected value="{{$request->kategori}}}">{{$pilih_kategori}}</option>').trigger('change');
	@endif




</script>

@stop