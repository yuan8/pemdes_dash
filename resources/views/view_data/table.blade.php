<?php
  $id_dom='table_'.rand(0,1000).date('is');
 ?>

<div class="box">
	 <div class="box-header with-border">
    <h5 class="text-center" ><b>{{isset($title)?$title:''}}</b></h5>
    <div class="btn-group">
          
      <button type="button" onclick="exportExcelTable('#table-{{$id_dom}}','{{isset($title)?$title:'export'}}');" class="btn btn-success">Download</button>
    </div>
    
  </div>
	<div class="box-body table-responsive">
		<table class="table table-bordered" id="table-{{$id_dom}}">
			<thead>
				<tr>
						@if($level!=10)

					<th rowspan="2">AKSI</th>
					@endif
					<th rowspan="2">KODEDAERAH</th>
					<th rowspan="2">NAMA {{strtoupper($level_meta['level'])}}</th>
					@if($level!=10)
					<th rowspan="2">JUMLAH DESA</th>
					<th rowspan="2">JUMLAH DESA TERDATA</th>
					@endif
					@foreach($table_meta['entity'] as $d)

					<th colspan="2">{{strtoupper(HPV::translate_operator($d['aggregate'])[0].' '.$d['name'])}}</th>
					@endforeach
					

				</tr>
				<tr>
					@foreach($table_meta['entity'] as $d)

					<th>NILAI</th>
					<th>SATUAN</th>

					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($data_type['data'] as $d)
					@php
						$d=(array)$d;
					@endphp
					<tr>
						@if($level!=10)
							<td>
								<button onclick="get_data('#dom_l_{{$level_meta['count']}}','{{route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'table'=>$table_meta['table'],'kdparent'=>$d['id']])}}')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
						@endif

						<td>{{$d['id']}}</td>
						<td>{{$d['name']}}</td>
							@if($level!=10)
						<td>{{HPV::nformat($d['jumlah_desa'])}}</td>
						<td>{{HPV::nformat($d['jumlah_data_desa'])}}</td>

					@endif
					@foreach($table_meta['entity'] as $key=> $x)

					<td>{{HPV::nformat($d['data_'.$key]??0)}}</td>
					<td>{{$d['data_'.$key.'_satuan']}}</td>

					@endforeach



					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>