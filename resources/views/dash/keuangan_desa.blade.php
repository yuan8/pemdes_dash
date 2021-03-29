@extends('vendor.adminlte.dashboard')

@section('content_header')
  <h2 class="text-center text-white" style="padding: 10px;"><b>{{$data['title']}}</b></h2>
@stop


@section('content')
<div class="box box-solid">
	<div class="box-body">
		<table class="table-bordered table">
			<thead>
				<tr>
				
				@foreach($data['header'] as $h)
					<th>{{$h}}</th>
				@endforeach
			</tr>
			</thead>
			<tbody>
			@foreach($data['data'] as $dt)
				<tr>
				
					@foreach($dt as $d)
						<th>{{is_number($d)?number_format($d,2,'.',','):$d}}</th>
					@endforeach
				</tr>

				@endforeach

			</tbody>
		</table>
	</div>
</div>

@stop