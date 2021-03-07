<form action="{{route('admin.dataview.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id])}}" method="post">
	@csrf
	@method('DELETE')
	<div class="modal-content">
		<div class="modal-header text-uppercase">
			Konfirmasi Penghapusan Data
		</div>
		<div class="modal-body text-uppercase">
			Menghapus Data {{$data->name}}
		</div>

		<div class="modal-footer">
			<button type="submit" class="btn btn-danger ">Hapus</button>
		</div>
	</div>

</form>