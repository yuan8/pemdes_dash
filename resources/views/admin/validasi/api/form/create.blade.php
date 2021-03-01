<form action="{{route('admin.validasi.try',['tahun'=>$GLOBALS['tahun_access'],'table'=>$table,'id'=>$data->kode_desa_data])}}" method="post">
	@csrf
	<div class="modal-content">
		<div class="modal-header">
			Validasi Data Desa {{$data->name}} 
		</div>

		<div class="modal-body">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="date" name="updated_at" required="" class="form-control">
			</div>
			<div class="form-group">
				<label>Keterangan</label>
				<textarea class="form-control" name="keterangan"></textarea>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary background-blue">Validasi</button>
		</div>
	</div>

</form>