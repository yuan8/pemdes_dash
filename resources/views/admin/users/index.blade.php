@extends('vendor.adminlte.admin')
@section('content_header')
<h4>USERS</h4>
<div class="btn-group">
	<button class="btn btn-success">TAMBAH</button>
</div>

@stop
@section('content')

<div class="box-solid box">
	<div class="box-body table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
				<th>AKSI</th>
				<th>STATUS</th>

				<th>NAME</th>
				<th>EMAIL</th>
				<th>ROLE</th>


			</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr>
						<td></td>
						<td></td>
						<td>{{$d->name}}</td>
						<td>{{$d->email}}</td>
						<td>{{HPV::role_user($d->role)['text']}}</td>



					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop


