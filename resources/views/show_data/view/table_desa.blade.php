<?php
  $id_dom='table_'.rand(0,1000).date('is');
 ?>

<div class="box box-primary">
	 <div class="box-header with-border">
	    <div class="btn-group" style="margin-bottom: 5px;">
				@if(Auth::Guard('api')->check() OR (Auth::check()))
		     		 <button type="button" onclick="exportExcelTable('#table-{{$id_dom}}','{{isset($title)?$title:'export'}}');" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download Excel</button>
		      @endif

	    </div>
	  </div>
	  <div class="box-body table-responsive"   >
		<table class="table table-bordered sticky-table" id="table-{{$id_dom}}" >
			<thead>
				
					<th rowspan="2">KODEDAERAH</th>
					<th rowspan="2">NAMA DESA</th>
					<th rowspan="2">STATUS PEMERITAHAN </th>
					<th rowspan="2">NAMA KECAMATAN </th>
					<th rowspan="2">NAMA KOTA/KAB </th>



					@foreach($table_meta['columns'] as $d)

						<th colspan="2" ><p>  <span> <button  data-html="true" data-trigger="fokus" class="btn btn-xs btn-ov"  data-toggle="popover" title="Meta Data"  data-content="<b>Definisi Data</b><br> {{($d['definisi']??'-')}}<br><b>Tipe Data</b><br>{{($d['tipe_data']??'-')}}" ><i class="fa fa-info" ></i></button></span>  {{strtoupper(HPV::translate_operator($d['aggregate_type'])[0].' '.$d['name'])}}</p></th>

					@endforeach
					

				</tr>
				<tr>
					@foreach($table_meta['columns'] as $d)
						<th>NILAI</th>
						<th>SATUAN</th>
					@endforeach
				</tr>
			</thead>
			<tbody style="">
				@foreach($data as $d)
					@php
						$d=(array)$d;
					@endphp
					<tr>
						
						<td scope="row" >{{$d['id']}}</td>
						<td scope="row" >{{$d['name']}}</td>
						<td >{{$d['status_desa']}}</td>
						<td >{{$d['nama_kecamatan']}}</td>
						<td >{{$d['nama_kota']}}</td>

						@foreach(array_values($table_meta['columns']) as $key=> $x)

						<td>{{HPV::nformat($d['data_'.$key]??0)}}</td>
						<td>{{$d['data_'.$key.'_satuan']}}</td>

						@endforeach



					</tr>
				@endforeach
			</tbody>
		</table>
		<script type="text/javascript">
			// $('#table-{{$id_dom}}').floatThead({
			// 	'position':'absolute'
			// });
			console.log('float run');
			 $('[data-toggle="popover"]').popover();
		</script>
	</div>
</div>