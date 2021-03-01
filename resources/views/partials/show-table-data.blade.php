<?php
	
	$data_table=HPV::data_set((array) $data);
	$fd=false;
?>


@if($data_table)
<ul class="nav nav-tabs">
  <li>
  	<a href="{{url($data->document_path)}}" download="" class="btn btn-primary"> <i class="fa fa-download"></i> Download </a>
  </li>
@foreach($data_table as $key=>$tb)
<li class="{{$fd==false?'active':''}}"><a data-toggle="tab" href="#sheet_{{str_replace(' ', '_', strtolower($key))}}"><b>{{$tb['title']}}</b></a></li>
<?php
	$fd=true;
?>
@endforeach
</ul>
<?php
	$fd=false;
?>


<div class="tab-content " style="padding:20px;">
	

@foreach($data_table as $key=>$tb)

<ul class="nav nav-tabs">
	
	@foreach(['2'=>'DATA_PROVINSI','4'=>'DATA_KOTA','7'=>'DATA_KECAMATAN','100'=>'DATA_DESA'] as $kskop=>$skop)
	<li class="{{$fd==false?'active':''}}"><a data-toggle="tab" href="#sheet_{{str_replace(' ', '_', strtolower($key))}}_{{$skop}}"><b>{{str_replace('_',' TINGKAT ',$skop)}}</b></a></li>
	<?php
		$fd=true;
	?>
	@endforeach
</ul>

@php
	$tb['header_x']=array_values($tb['header']);
@endphp
<div id="sheet_{{str_replace(' ', '_', strtolower($key))}}" class=" table-responsive tab-pane fade in {{$fd==false?'active':''}}">
	<?php
	$fd=true;
?>
<h5 class="text-center"><b>{{$tb['title']}}</b></h5>
<hr>
	<div class="table-responsive">
		<table class="table-bordered table" id="tb_dataset_{{$key}}_PROVINSI">
	<thead>
		<tr>
			<th rowspan="2">KODE DAERAH</th>
			<th rowspan="2">NAMA DAERAH</th>
			@foreach($tb['header_x'] as $h)
			<th colspan="2">{{$h['text']}}</th>
			@endforeach

		</tr>
		<tr>
			@foreach($tb['header_x'] as $h)
			<th >NILAI ({{$h['aggregate']}})</th>
			<th >SATUAN</th>
			@endforeach
			
		</tr>
		<tr>
			
			<th>1</th>
			<th>2</th>
			@foreach($tb['header_x'] as $keyhh=>$h)
			<th> {{(($keyhh*2)+3)}}</th>
			<th> {{(($keyhh*2)+4)}}</th>
			@endforeach

		</tr>
	</thead>
	<tbody>
		@foreach($tb['DATA_KOTA'] as $d)
		@php
			$d['data_x']=array_values($d['data']);
		@endphp
		<tr>
			<td>{{$d['meta']['kodedaerah']}}</td>
			<td>{{$d['meta']['namadaerah']}}</td>

		@foreach($d['data_x'] as $k=>$x)
		<td>{{HPV::nformat($x)}}</td>
		<td>{{$tb['header_x'][$k]['satuan']}}</td>

		@endforeach
		</tr>

		@endforeach
	</tbody>
</table>
	</div>
</div>

@endforeach
</div>


<script type="text/javascript">
	$('#tb_dataset_{{$key}}_PROVINSI').dataTable();
</script>
@endif