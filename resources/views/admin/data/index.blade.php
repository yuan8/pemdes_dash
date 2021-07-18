@extends('vendor.adminlte.admin')
@section('content_header')
<h4>DATA</h4>
<div class="btn-group">
	@can('is_only_daerah')
<a href="{{route('admin.data.create',['tahun'=>$GLOBALS['tahun_access'],'type'=>'VISUALISASI'])}}" class="btn btn-success">TAMBAH DATA VISUALISASI</a>
<a href="{{route('admin.data.create',['tahun'=>$GLOBALS['tahun_access'],'type'=>'TABLE'])}}" class="btn btn-success">TAMBAH DATA TABLE</a>


<a href="{{route('admin.data.create',['tahun'=>$GLOBALS['tahun_access'],'type'=>'INFOGRAFIS'])}}" class="btn btn-success">TAMBAH DATA INFOGRAFIS</a>
	@endcan
	
</div>
<style type="text/css">
	td{
		vertical-align: middle!important;
	}
</style>
<hr style="background: #fff; border-color: #fff;">
<form method="get">
	<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label>TEMA</label>
			<select class="form-control" id="tema" name="tema">
				<option value="">SEMUA</option>
				<option value="TEMA_DATA_UTAMA" {{$request->tema=='TEMA_DATA_UTAMA'?'selected':''}}>TEMA UTAMA</option>
				<option value="TEMA_DATA_PENDUKUNG" {{$request->tema=='TEMA_DATA_PENDUKUNG'?'selected':''}}>TEMA PENDUKUNG</option>
			</select>
		</div>


	</div>

	<div class="col-md-3">
		<div class="form-group">
			<label>KATEGORI</label>
			<select class="form-control" id="kategori" name="kategori">
			
			</select>
		</div>

		
	</div>

	<div class="col-md-3">
		<div class="form-group">
			<label>JENIS</label>
			<select class="form-control" id="jenis" name="jenis">
				<option value="">SEMUA</option>
				<option value="VISUALISASI" {{$request->jenis=='VISUALISASI'?'selected':''}} >VISUALISASI</option>
				<option value="TABLE"  {{$request->jenis=='TABLE'?'selected':''}}>TABLE</option>
				<option value="INFOGRAFIS"  {{$request->jenis=='INFOGRAFIS'?'selected':''}}>INFOGRAFIS</option>
				


			</select>
		</div>

		
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>STATUS</label>
			<select class="form-control" id="status" name="status">
				<option value="">-</option>
				@foreach(HP::status_kode_verifikasi_dataset() as $key=>$d)
				<option value="{{$key}}"  {{$request->status==$key?'selected':''}}>{{$d}}</option>
				@endforeach	
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
					<th>JENIS DATA</th>

					<th>JUDUL</th>
					<th>KETEGORI</th>


					<th>JENIS INSTANSI</th>
					<th>NAMA INSTANSI</th>

					<th>STATUS</th>
					<th>DIBUAT OLEH</th>

					<th>UPDATE TERAHIR</th>


				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr class="{{$d->status==0?"bg-maroon":($d->status==2?'bg-yellow':'')}}">
						<td class="bg-gray">
							<div class="btn-group-vertical">
								<a href="{{route('data.vis.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'slug'=>Str::slug($d->title),'preview'=>true])}}" class="btn btn-xs btn-info"> <i class="fa fa-eye"></i> </a>
							<a href="{{route('admin.dataset.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-xs btn-warning"> <i class="fa fa-pen"></i> </a>
							<button onclick="showForm('{{route('admin.dataview.form_delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i> </buttom>

							</div>
						</td>
						<td class="bg-gray">
								@switch($d->type)
								    @case('TABLE')
								       <i class="fa fa-table"></i> TABLE
								        @break
								      @case('VISUALISASI')
								       <i class="fa fa-area-chart"></i> CHART VISUAL
								       @break
								       @case('INFOGARFIS')
								       <i class="fa fa-picture"></i> INFOGRAFIS
								       @break
								
								    @default
								            Default case...
								@endswitch
								

						</td>
						<td>{{$d->title}}</td>
						<td>{{$d->nama_category}}</td>
						<td>{{$d->jenis_instansi}}</td>
						<td>{{($d->nama_instansi)?$d->nama_instansi:HP::daerah_level($d->kode_daerah)}}</td>
						<td>{{HP::status_verifikasi_dataset($d->status)}}</td>
						<td>{{$d->nama_user_created. ' , '.$d->jabatan_user_created}}</td>

						<td>{{\Carbon\Carbon::parse($d->updated_at)->format('d F Y')}}</td>



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


	

	$(function(){
		setTimeout(function(){
		$('#kategori').select2();
		$('#status').select2();

		$('#tema').select2();
		$('#tema').on('change',function(){
			ketegori();
		});

		$('#tema').trigger('change');

		$('#jenis').select2();

		@if($request->kategori)
		$('#kategori').html('<option selected value="{{$request->kategori}}}">{{$pilih_kategori}}</option>').trigger('change');
	@endif
		},500);
	});






</script>

@stop