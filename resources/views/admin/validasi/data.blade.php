@extends('vendor.adminlte.admin')
@section('content_header')
<h4>VALIDASI DATA</h4>
<div class="form-group">
	<label>DATA</label>
	<form method="get">
		<div class="row">
			<div class="col-md-6">
				<select class="form-control" name="data" onchange="$(this).parent().parent().parent().submit()">
		@foreach($table as $key=>$t)
			<option value="{{$key}}" {{$data_index==$key?'selected':''}} >{{$t['name']}}</option>
		@endforeach
		</select>
			</div>
		</div>
	</form>
</div>
@stop


@section('content')

<div class="box box-primary">
	<div class="box-body table-responsive">
		@if(count($data)>0)
			<table class="table-bordered table">
			<thead>
				<tr>
					@foreach($data[0] as $key=>$x)
						<th>{{str_replace('_',' ',$key)}}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr>
						@foreach($d as $x)
							<td>{{$x}}</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>

		@else
			<h3 class="text-center text-danger"><b>DATA TIDAK TERSEDIA</b></h3>
		@endif
	</div>
</div>

@stop