@extends('vendor.adminlte.admin')


@section('content')

<div class="box box-solid">
	<div class="box-body">
		<table class="table-bordered table">
			<thead>
				<tr>
					<th>AKSI</th>
					<th>NO.</th>
					<th>IMAGE</th>
					<th>NAMA</th>
					<th>ROUTE ACCESS</th>
					<th>DESKRIPSI</th>

				</tr>
			</thead>
			<tbody>
				@foreach($data as $key=>$d)
					<tr>
						<td></td>
						<td>{{$key+1}}</td>
						<td>{{$key+1}}</td>
						<td>{{$key+1}}</td>
						<td>{{$key+1}}</td>

					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@stop

@section('js')





@stop
