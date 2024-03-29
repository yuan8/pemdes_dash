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
		<p>{{$data->total()}} User</p>
		<form action="{{url()->full()}}" method="get">
			<input type="text" class="form-control" placeholder="Cari.."  name="q" value="{{isset($_GET['q'])?$_GET['q']:''}}">
			
		</form>
	</div>
	<div class="box-body ">
		<div class="table-responsive">
			<table class="table table-bordered table-condensed" id="table-user">
			<thead>
				<tr>
				<th>AKSI</th>
				<th>AKSES API</th>

				<th>NAME</th>
				<th>USERNAME</th>

				<th>EMAIL</th>
				<th>KODE DAERAH</th>

				<th>ROLE</th>
				<th>NOMER TELPON</th>
				<th>WA BLASH</th>


				{{-- <th>AKSES API</th> --}}
				<th>STATUS</th>

			</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr class="{{$d->is_active==TRUE?'':'bg-maroon'}}">
						<td>
							<div class="btn-group">
								<a href="{{route('admin.users.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}" class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> Edit</a>
							</div>
						</td>
						<td class="text-center {{$d->api_access?'bg-primary':''}}">
							@if($d->api_access)
								<i class="fa fa-check"></i>
							@else
								<i class="fa fa-times"></i>

							@endif
						</td>
						
						<td>{{$d->name}}</td>
						<td>{{$d->username}}</td>

						<td>{{$d->email}}</td>
						<td>{{$d->kode_daerah}}</td>

						<td>{!!HPV::role_user($d->role,$d)['text']!!}</td>
						<td>
							{{$d->nomer_telpon}}
						</td>
						<td>
							{{$d->wa_notif?"ACTIVE":'NON ACTIVE'}}
						</td>
						{{-- <td>
							@if($d->access_web)
								<i class=" text-success fa fa-check"></i> ACCESS
							@else
								NO ACCESS
							@endif
							
						</td>
						<td>
							@if($d->access_api)
								<div class="btn-group">
									<button class="btn btn-xs one-line" disabled="" style="width:100px;">{{$d->api_token}}</button>
									<button class="btn btn-primary btn-xs">
										<i class="fa fa-copy"></i>
									</button>
								</div>
							@else
								NO ACCESS
							@endif
						</td> --}}
						<td>{{$d->is_active==TRUE?"ACTIVE":'UNACTIVE'}}</td>




					</tr>
				@endforeach
			</tbody>
		</table>
		</div>
		{{$data->links()}}
	</div>
</div>
@stop


