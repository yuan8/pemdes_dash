
<div class="modal-content">
		<div class="modal-header text-uppercase">
			List User 
		</div>
		<div class="modal-body text-uppercase">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>NAMA</th>
							<th>EMAIL</th>
							<th>JABATAN</th>
							<th>PHONE</th>
						</tr>
					</thead>
					@foreach($data as $d)
					<tr>
						<td>{{$d->name}}</td>
						<td>{{$d->email}}</td>
						<td>{{$d->jabatan}}</td>

						<td>

							{{$d->nomer_telpon}}
							@if(strlen($d->nomer_telpon)>=10)
							<br>
								 <div class="btn-group">
								 	<a target="_blank" href="https://wa.me/{{str_replace('+','',str_replace('-','',$d->nomer_telpon) )}}?text=DATA TERKAIT {{$nama_data}} DI {{$daerah}}" class="btn btn-success btn-xs"><i class="fa fa-whatsapp"></i> Message</a></span>
								 </div>
							@endif
						</td>

					</tr>
					@endforeach
				</table>
			</div>
		</div>

		<div class="modal-footer">
		</div>
	</div>

