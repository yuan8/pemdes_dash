<form action="" method="post">
	@csrf
	@method('PUT')
	<div class="modal-content">

	<div class="modal-header">
	<H4>Edit Valisadi Desa {{$data->name}}</H4>
	</div>

	<div class="modal-body">
		<h5><b>Data {{HPV::table_data($table)['name']}}</b></h5>
		<div class="form-group">
			<label>Tanggal</label>
			<input type="date" name="updated_at" value="{{\Carbon\Carbon::parse($data->tanggal_validasi)->format('Y-m-d')}}" class="form-control">
		</div>
		<div class="form-group">
			<label>Keterangan</label>
			<textarea class="form-control" name="keterangan">{!!$data->keterangan!!}</textarea>
		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary background-blue">Update Validasi</button>
	</div>
</div>
<div class="modal-body bg-danger">
		<form action="" method="post">
			@csrf
			@method('DELETE')
			<button type="submit" class="btn btn-danger btn-sm "><i class="fa fa-trash"></i></button>
			<input type="checkbox" required="" name="confirm"> <span>Konfirmasi Penghapusan</span>
		</form>
	
</div>

</form>