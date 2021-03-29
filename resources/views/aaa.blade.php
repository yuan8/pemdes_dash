<table >
	<tr>
		<th>
			DATABASE
		</th>
		<th>ID DAERAH</th>

		<th>KODEDAERAH</th>
		<th>KODEDAERAH 2</th>
		<th>NAMA DAERAH</th>

	</tr>
	<tbody>
		@foreach($data as $key=>$d)
			@foreach($d as $dd)
				<tr>
					<td>{{$key}}</td>
					
					<td>{{$dd->id}}</td>
					<td>{{str_replace('.','',$dd->kodedaerah)}}</td>
					<td>{{$dd->kodedaerah2}}</td>
					<td>{{$dd->nama_daerah}}</td>

				</tr>
			@endforeach

		@endforeach
	</tbody>
</table>