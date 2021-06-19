@extends('vendor.adminlte.admin')
@section('content_header')
<h4>REKAP DATA BERITA ACARA TAHUN {{$GLOBALS['tahun_access']}} </h4>
@stop


@section('content')
	<div class="box box-solid">
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>NO</th>
							<th>DATA</th>
							<th>BERITA ACARA</th>
							<th>BERITA ACARA PENGESAHAN</th>

						</tr>
					</thead>
					<tbody>
						@foreach ($rekap as $key=>$b)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$b['name']}}</td>
								<td>
									<a href="{{$b['file_source']}}" class="btn btn-primary btn-xs">Download Berita Acara</a>
								</td>
								<td>
									<a href="{{$b['file_source']}}" class="btn btn-primary btn-xs">Download Berita Acara</a>
								</td>

							</tr>
							{{-- expr --}}
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop