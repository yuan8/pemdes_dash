@php
	$id_dom='table_'.rand(0,100);
@endphp

<h3 class="text-center"><b>{{$data['title']}}</b></h3>
		<div class="box box-solid">
	<div class="box-body">


<div class="row">

	<div class="col-md-12">
		@include('chart.bar',['data'=>$data,'series'=>$series,'title'=>$data['title']])
	</div>
	<div class="col-md-12">
		<button type="button" onclick="exportExcelTable('#table-{{$id_dom}}','{{isset($title)?$title:'data keuangan desa tahun '.$GLOBALS['tahun_access']}}');" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download Excel</button>
	</div>
	<div class="col-md-12 table-responsive">
		<table class="table-bordered table" id="table-{{$id_dom}}">
			<thead>
				<tr>
				
				@foreach($data['header'] as $h)
					<th>{{$h=='%'?'%(Persen)':$h}}</th>
				@endforeach
			</tr>
			</thead>
			<tbody>
			@foreach($data['data'] as $dt)
				<tr>
					@php
					@endphp
					@foreach($dt as $k=>$d)
						@if(strtoupper($data['header'][$k])=='TAHUN')
						<th>{{$d}}</th>
						@else
						<th>{{is_numeric($d)?number_format($d,2,',','.'):$d}}</th>

						@endif
						@php
						@endphp

					@endforeach
				</tr>

				@endforeach

			</tbody>
		</table>
	</div>
</div>
	</div>
</div>