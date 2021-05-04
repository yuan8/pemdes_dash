<?php
$id_dom='max_view_'.rand(0,100).'_'.date('is');
$colors=['bg-blue','bg-green','bg-yellow','bg-red'];
?>
<h4 class="text-uppercase"><b> {{HPV::nformat(count($data_type['data_sort']['max']))}} {{$title}} TERTINGGI  {{strtoupper($pemda)=='PER PROVINSI'?'PROVINSI':$pemda}}</b></h4>
<div class="row">

	@foreach($data_type['data_sort']['max'] as $key=> $d)
	<div class="col-md-{{(int)(12/count($data_type['data_sort']['max']))}}">
		<div class="info-box {{$colors[$key]}}">
			<span class="info-box-icon">
				{{$key+1}}.

			</span>
			<div class="info-box-content">
				<h4><b>{{$d['name']}}</b></h4>
				<p><b>{{HPV::nformat($d['value'])}} {{$d['satuan']}}</b></p>
			</div>
		</div>
	</div>
@endforeach
</div>
<hr>