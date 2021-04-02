<?php
  $id_dom='table_'.rand(0,1000).date('is');
 ?>

<div class="box box-primary">
	 <div class="box-header with-border">
    <div class="btn-group" style="margin-bottom: 5px;">
		@if(!isset($only1level))
			@if(Auth::Guard('api')->check() OR (Auth::check()))
	      <button type="button" onclick="exportExcelTable('#table-{{$id_dom}}','{{isset($title)?$title:'export'}}');" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download Excel</button>
	      @endif
	      @endif
    </div>
  </div>
	<div class="box-body table-responsive"   >
		<table class="table table-bordered sticky-table" id="table-{{$id_dom}}" >
			<thead>
				<tr>
					@if($level!=10)
						@if(!isset($only1level))
							<th class="no-export"></th>
						@endif
					@endif

					<th colspan="{{ (($level!=10)?4:2) +(count($table_meta['columns'])*2) }}">
						<p class="text-uppercase">{{isset($title)?$title:''}} {{isset($pemda)?$pemda:''}}</p>
					</th>

				</tr>
				<tr>
					@if($level!=10)
						@if(!isset($only1level))
							<th rowspan="2" class="no-export">AKSI</th>
						@endif
					@endif
						<th rowspan="2">KODEDAERAH</th>
						<th rowspan="2">NAMA {{strtoupper($level_meta['level'])}}</th>
					@if($level!=10)
					<th rowspan="2">JUMLAH DESA</th>
					<th rowspan="2">JUMLAH DESA TERDATA</th>
					@endif
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
				@foreach($data_type['data'] as $d)
					@php
						$d=(array)$d;
					@endphp
					<tr>
						@if($level!=10)
					@if(!isset($only1level))

							<td scope="row" class="no-export">
								@if(isset($dataset))
								<button onclick="get_data('#dom_l_{{$level_meta['count']}}','{{route('visual.dataset',['tahun'=>$GLOBALS['tahun_access'],'id'=>$id_dataset,'kdparent'=>$d['id']])}}')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
								@else
								<button onclick="get_data('#dom_l_{{$level_meta['count']}}','{{route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d['id_data'],'table'=>$table_meta['key_view'],'kdparent'=>$d['id']])}}')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>

								@endif
							</td>
						@endif
						@endif


						<td scope="row" >{{$d['id']}}</td>
						<td scope="row" >{{$d['name']}}</td>
							@if($level!=10)
						<td>{{HPV::nformat($d['jumlah_desa'])}}</td>
						<td>{{HPV::nformat($d['jumlah_data_desa'])}}</td>

					@endif
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