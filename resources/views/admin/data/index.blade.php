@extends('vendor.adminlte.admin')
@section('content_header')
<h4>DATA</h4>
<div class="btn-group">
<a href="{{route('admin.data.create',['type'=>'VISUALISASI'])}}" class="btn btn-success">TAMBAH DATA VISUALISASI</a>
<a href="{{route('admin.data.create',['type'=>'DATA_SET'])}}" class="btn btn-success">TAMBAH DATA SET</a>
<a href="{{route('admin.data.create',['type'=>'INFOGRAFIS'])}}" class="btn btn-success">TAMBAH DATA INFOGRAFIS</a>

</div>
<hr style="background: #fff; border-color: #fff;">
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>TEMA</label>
			<select class="form-control" id="tema" name="tema">
				<option value="">SEMUA</option>
				<option value="TEMA_PRIMER">TEMA UTAMA</option>
				<option value="TEMA_SEKUNDER">TEMA PENDUKUNG</option>
			</select>
		</div>


	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>KATEGORI</label>
			<select class="form-control" id="kategori" name="kategori">
				<option value="">SEMUA</option>
			</select>
		</div>

		
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>JENIS</label>
			<select class="form-control" id="jenis" name="jenis">
				<option value="">SEMUA</option>
				<option value="VISUALISASI">VISUALISASI</option>
				<option value="DATA_SET">DATA SET</option>
				<option value="INFOGRAFIS">INFOGRAFIS</option>


			</select>
		</div>

		
	</div>
</div>
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
						<td></td>
						<td>{{$d->delivery_type}}</td>
						<td>{{str_replace('_',' ',$d->tema)}}</td>

						<td>{{$d->nama_category}}</td>
						<td>{{$d->name}}</td>
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
	
</script>

@stop