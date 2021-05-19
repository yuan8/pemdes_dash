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
		<form action="{{url()->full()}}" method="get">
			<input type="text" class="form-control" placeholder="Cari.."  name="q" value="{{isset($_GET['q'])?$_GET['q']:''}}">
			
		</form>
	</div>
	<div class="box-body table-responsive">
		<table class="table table-bordered" id="table-user">
			<thead>
				<tr>
				<th>AKSI</th>
				<th>NAME</th>
				<th>EMAIL</th>
				<th>ROLE</th>
				<th>AKSES WEB</th>
				<th>AKSES API</th>
				<th>STATUS</th>

			</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr class="{{$d->is_active==TRUE?'':'bg-warning'}}">
						<td>
							<div class="btn-group">
								<a href="{{route('admin.users.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> Edit</a>
							</div>
						</td>
						
						<td>{{$d->name}}</td>
						<td>{{$d->email}}</td>
						<td>{{HPV::role_user($d->role)['text']}}</td>
						<td>
							{{-- @if($d->access_web)
								<i class=" text-success fa fa-check"></i> ACCESS
							@else
								NO ACCESS
							@endif --}}
							
						</td>
						<td>
							{{-- @if($d->access_api)
								<div class="btn-group">
									<button class="btn btn-xs one-line" disabled="" style="width:100px;">{{$d->api_token}}</button>
									<button class="btn btn-primary btn-xs">
										<i class="fa fa-copy"></i>
									</button>
								</div>
							@else
								NO ACCESS
							@endif --}}
						</td>
						<td>{{$d->is_active==TRUE?"ACTIVE":'UNACTIVE'}}</td>




					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop


