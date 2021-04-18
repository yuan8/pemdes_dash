@extends('vendor.adminlte.admin')
@section('content_header')
<h4>USER DASHBOARD</h4>
@stop


@section('content')
<H5>USER LOGIN</H5>
<div class="box box-solid">
	<div class="box-hedaer with-border">
		<form action="{{url()->full()}}" method="get">
			<input type="text" class="form-control" placeholder="Cari.."  name="q" value="{{isset($_GET['q'])?$_GET['q']:''}}">
		</form>
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<td>AKSI</td>
						<td>NAMA</td>
						<td>ROLE</td>
						<td>EMAIL</td>
						<td>IP ADDRESS</td>
						<td>USER AGENT</td>

					</tr>
				</thead>
				<tbody>
					@foreach ($data as $d)
						<tr>
							<td></td>
							<td>{{$d->name}}</td>
							<td>{{HPV::role_user($d->role)['text']}}</td>
							<td>{{$d->email}}</td>


							<td>{{$d->ip_address}}</td>
							<td>{{$d->user_agent}}</td>




						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{$data->links()}}
	</div>
</div>

@stop