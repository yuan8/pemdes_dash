<h3 class="text-center"><b>{{$data['title']}}</b></h3>

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
						<th>{{$d}}</th>
					@endforeach
				</tr>

				@endforeach

			</tbody>
		</table>
	</div>
</div>