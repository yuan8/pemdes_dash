

<h3 class="text-center"><b>{{$data['title']}}</b></h3>
		<div class="box box-solid">
	<div class="box-body">


<div class="row">

	<div class="col-md-12">
		@include('chart.column',['data'=>$data,'series'=>$series,'title'=>$data['title']])
	</div>
	<div class="col-md-12 table-responsive">
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
						<th>{{is_numeric($d)?number_format($d,2,',','.'):$d}}</th>

					@endforeach
				</tr>

				@endforeach

			</tbody>
		</table>
	</div>
</div>
	</div>
</div>