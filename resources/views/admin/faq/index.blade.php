@extends('vendor.adminlte.admin')
@section('content_header')
<h4>FAQ</h4>
<div class="btn-group">
	<a href="" class="btn btn-success">Tambah FAQ</a>
</div>

@stop

@section('content')
	<div class="col-dm-12">
		<div class="box box-solid">
			<div class="box-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Kategory</th>
							<th>Pertanyaan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $d)
						<tr>
							<td>{{$d->cat_nama}}</td>
							<td>{{$d->question}}</td>
							<td></td>

						</tr>
							{{-- expr --}}
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop