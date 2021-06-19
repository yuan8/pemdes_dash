@extends('vendor.adminlte.admin')
@section('content_header')
<h4>REKAP STATUS DATA TAHUN {{$GLOBALS['tahun_access']}}</h4>
<small>{{HP::daerah_level(Auth::User()->kode_daerah)}}</small>

@stop


@section('content')
<div class="row">
	@foreach ($data as $d)
		{{-- expr --}}
		@if(strlen(Auth::User()->kode_daerah)>6)
		<div class="col-md-6">
			<div class="box-solid box">
				<div class="box-header with-border">
					<h4>{{$d['name']}}  
					</h4>
					
				</div>
				<div class="box-body">
						<b>@if($d['rekap']['kat_2'])
						<p class="text-red">DIVERIFIKASI DESA/KEL</p>
						@elseif($d['rekap']['kat_3'])
						<p class="text-yellow">DIVERIFIKASI KECAMATAN</p>
						@elseif($d['rekap']['kat_5'])
						<p class="text-green">TERVALIDASI KAB/KOTA</p>
						@else
						<p>BELUM TERDAPAT STATUS</p>
						@endif
				</div>
			</div>
		</div>
		@else
		<div class="col-md-6">
			<div class="box-solid box">
				<div class="box-header with-border">
					<h4>{{$d['name']}} - TOTAL DESA {{HPV::nformat($d['jumlah_desa'])}} </h4>
				</div>
				<div class="box-body">
					<label>{{str_replace('Telah ','',HP::verifikasi_status(2))}} {{(round($d['rekap']['kat_2']/$d['jumlah_desa'],2)??0)*100}}% - {{HPV::nformat($d['rekap']['kat_2'])}} Desa</label>
					<div class="progress progress-xs">
		                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{(round($d['rekap']['kat_3']/$d['jumlah_desa'],2)??0)*100}}%">
		                  <span class="sr-only">{{(round($d['rekap']['kat_2']/$d['jumlah_desa'],2)??0)*100}}% Complete (warning)</span>
		                </div>
	             	 </div>
					<label>{{str_replace('Telah ','',HP::verifikasi_status(3))}} {{(round($d['rekap']['kat_3']/$d['jumlah_desa'],2)??0)*100}}% - {{HPV::nformat($d['rekap']['kat_3'])}} Desa</label>

	             	 <div class="progress progress-xs">
		                <div class="progress-bar progress-bar-primary	 progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{(round($d['rekap']['kat_3']/$d['jumlah_desa'],2)??0)*100}}%">
		                  <span class="sr-only">{{(round($d['rekap']['kat_3']/$d['jumlah_desa'],2)??0)*100}}% Complete (warning)</span>
		                </div>
	             	 </div>
					<label>{{HP::verifikasi_status(5)}} {{(round($d['rekap']['kat_5']/$d['jumlah_desa'],2)??0)*100}}% - {{HPV::nformat($d['rekap']['kat_5'])}} Desa</label>

	             	 <div class="progress active progress-xs">
		                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{(round($d['rekap']['kat_5']/$d['jumlah_desa'],2)??0)*100}}%">
		                  <span class="sr-only">{{(round($d['rekap']['kat_5']/$d['jumlah_desa'],2)??0)*100}}% Complete (warning)</span>
		                </div>
	             	 </div>
					
				</div>
			</div>
		</div>
		@endif
	@endforeach
</div>
@stop

@section('js')
<script type="text/javascript">
	var maxH=0;
	$('.box').each((k,d)=>{
		if(maxH<=($(d).height())){
			maxH=($(d).height());
		}

	});
	$('.box').css('min-height',maxH);


</script>
@stop