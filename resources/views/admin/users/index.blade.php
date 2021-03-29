@extends('vendor.adminlte.admin')
@section('content_header')
<h4>USERS</h4>
<div class="btn-group">
	<a href="{{route('admin.users.add',['tahun'=>$GLOBALS['tahun_access']])}}" class="btn btn-success">TAMBAH</a>
</div>

@stop
@section('content')

<div class="box-solid box">
	<div class="box-header">
		<input type="text" class="form-control" placeholder="Cari.."  name="">
	</div>
	<div class="box-body table-responsive">
		<table class="table table-bordered" id="table-user">
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
					<tr class="{{$d->is_active?'':'bg-warning'}}">
						<td>
							<div class="btn-group">
								<a href="{{route('admin.users.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> Edit</a>
							</div>
						</td>
						<td>
							dsds
						</td>
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


