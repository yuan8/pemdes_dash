@extends('vendor.adminlte.admin')
@section('content_header')
<h4>REKAP STATUS DATA TAHUN {{$GLOBALS['tahun_access']}}</h4>
<small>{{HP::daerah_level(Auth::User()->kode_daerah)}}</small>

@stop


@section('content')
<div class="row">
	@foreach ($data as $d)
		{{-- expr --}}
		<div class="col-md-6">
			<div class="box-solid box">
				<div class="box-header with-border">
					<h4>{{$d['name']}}</h4>
				</div>
				<div class="box-body">
					<label>{{str_replace('Telah ','',HP::verifikasi_status(2))}} {{(round($d['rekap']['kat_2']/$d['jumlah_desa'],2)??0)*100}}%</label>
					<div class="progress progress-xs">
		                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{(round($d['rekap']['kat_3']/$d['jumlah_desa'],2)??0)*100}}%">
		                  <span class="sr-only">{{(round($d['rekap']['kat_2']/$d['jumlah_desa'],2)??0)*100}}% Complete (warning)</span>
		                </div>
	             	 </div>
					<label>{{str_replace('Telah ','',HP::verifikasi_status(3))}} {{(round($d['rekap']['kat_3']/$d['jumlah_desa'],2)??0)*100}}%</label>

	             	 <div class="progress progress-xs">
		                <div class="progress-bar progress-bar-primary	 progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{(round($d['rekap']['kat_3']/$d['jumlah_desa'],2)??0)*100}}%">
		                  <span class="sr-only">{{(round($d['rekap']['kat_3']/$d['jumlah_desa'],2)??0)*100}}% Complete (warning)</span>
		                </div>
	             	 </div>
					<label>{{HP::verifikasi_status(5)}} {{(round($d['rekap']['kat_5']/$d['jumlah_desa'],2)??0)*100}}%</label>

	             	 <div class="progress active progress-xs">
		                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{(round($d['rekap']['kat_5']/$d['jumlah_desa'],2)??0)*100}}%">
		                  <span class="sr-only">{{(round($d['rekap']['kat_5']/$d['jumlah_desa'],2)??0)*100}}% Complete (warning)</span>
		                </div>
	             	 </div>
					
				</div>
			</div>
		</div>
	@endforeach
</div>
@stop