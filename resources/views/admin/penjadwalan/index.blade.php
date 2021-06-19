@extends('vendor.adminlte.admin')
@section('content_header')
<h4>PENJADWALAN PELAPORAN DATA TAHUN {{$GLOBALS['tahun_access']}}</h4>

@stop


@section('content')

<div class="box box-solid">
	<form method="post" action="{{route('a.p.update',['tahun'=>$GLOBALS['tahun_access']])}}">
		@csrf
		@method('PUT')
		<div class="box-body">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>NAMA</th>
						<th>MULAI</th>
						<th>SELESAI</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $key=>$d)
						<tr>
							<td>{{$d['level_name']}}</td>
							<td>
								<input type="date" value="{{$d['mulai']?$d['mulai']->format('Y-m-d'):null}}" class="form-control" name="penjadwalan[{{$d['level']}}][mulai]">
							</td>
							<td>
								<input type="date" class="form-control" value="{{$d['selesai']?$d['selesai']->format('Y-m-d'):null}}" name="penjadwalan[{{$d['level']}}][selesai]">
							</td>

						</tr>
					@endforeach

				</tbody>
				
			</table>
		</div>
	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary">SIMPAN</button>
	</div>
	</form>
</div>

@stop

@section('js')
<script type="text/javascript">
	$('#table-id').dataTable({
		'pageLength':false,
		'lengthChange':false,
		'ordering':false,
		'paging':false

	});
</script>




@stop
