@extends('layouts.export')

@section('content')
	<style type="text/css">
		th,td{
			font-size:10px;
		}
	</style>
	<h2 class="text-center" style="margin:2px;">BERITA ACARA DATA {{strtoupper($table_map['data_name'])}}</h2>
	<h3 class="text-center" style="margin:2px;">{{strtoupper($daerah['nama_daerah'])}}</h3>
	<p class="text-center">{{Carbon\Carbon::parse($now)->format('d F Y')}}</p>
	<hr>
	<h3>META DATA {{strtoupper($table_map['data_name'])}}</h3>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>DATA</th>
				<th>DEFINISI</th>
				<th>SATUAN</th>
				<th>TIPE DATA</th>
				<th>INTERVAL NILAI</th>
			</tr>
		</thead>
		<tbody>
			@foreach($table_map['columns'] as $c)
			<tr>
				<td>{{($c['name'])}}</td>
				<td>{{($c['definisi'])}}</td>
				<td>{{($c['satuan'])}}</td>
				<td>{{($c['tipe_data'])}}</td>
				<td>{{(implode(',',explode('|;|', $c['interval_nilai'])))}}</td>


			</tr>
			@endforeach
		</tbody>
	</table>
	@foreach ($data['data'] as $kecamatan)
	@php
		$kecamatan=(array)$kecamatan;
	@endphp
	<hr>

	<h3 class="text-center"><b>{{$kecamatan['nama']}}</b></h3>
	<div class="row">
		<div class="col-xs-4">
			<div class="panel bg-blue ">
				<div class="panel-body">
					<h5>JUMLAH DESA</h5>
					<p><b>{{HPV::nformat($kecamatan['jumlah_desa'])}} Desa</b></p>
				</div>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="panel bg-blue ">
				<div class="panel-body">
					<h5>JUMLAH DESA TERDATA</h5>
					<p><b>{{HPV::nformat($kecamatan['jumlah_data'])}} Desa</b></p>
				</div>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="panel bg-blue ">
				<div class="panel-body">
					<h5>PERSENTASE PELAPORAN</h5>
					<p><b>{{HPV::nformat($kecamatan['persentase_pelaporan'])}} %</b></p>
				</div>
			</div>
		</div>
	</div>
	<h4><b>1. LEMBAR DATA {{strtoupper($table_map['data_name'])}}</b></h4>

	<table class="table table-bordered">
		<thead>
			<thead>
					<tr>
						<th rowspan="2" >KODEDESA</th>
						<th rowspan="2" >DESA</th>
						<th rowspan="2" >STATUS DESA</th>

						@foreach($table_map['columns'] as $key=>$x)
							@php
							@endphp
							<th colspan="2">{{strtoupper($x['name'].'')}}</th>
						@endforeach
					</tr>
					<tr>
						@foreach($table_map['columns'] as $key=>$x)
							@php
							@endphp
							<th>SATUAN</th>
							<th>
								NILAI
							</th>
						@endforeach
					</tr>
				</thead>
			
		</thead>
		<tbody>
			@foreach ($kecamatan['data'] as $d)
				<tr>
					<td>{{$d->id}}</td>
					<td>{{$d->name}}</td>
					<td>{{$d->status_desa}}</td>
					@php
						$data_colm=(array)$d;
					@endphp
					@foreach ($table_map['columns'] as $key=>$c)
							<td>{!!$c['satuan']??'-'!!}</td>
							<td>{{HPV::nformat($data_colm[$key]??'-')}}</td>
							
					@endforeach

				</tr>
			@endforeach
			
		</tbody>
	</table>
	<h4><b>2. LEMBAR PENGESAHAN DATA {{strtoupper($table_map['data_name'])}}</b></h4>
	<p class="text-right">{{$kecamatan['nama']}},...,.....,{{$GLOBALS['tahun_access']}}</p>
	<div class="row">
		@foreach ($kecamatan['walidata'] as $kwali=> $wali)
		@php
			$wali=(array)$wali;
		@endphp
			<div class="col-md-4 col-sm-4 col-xs-4">
				<p class="text-center">WALIDATA {{$kwali+1}} {{$kecamatan['nama']}}</p>
				<br>
				<br>
				<p class="text-center"  style="margin:0px; padding: 0px;"><b>{{$wali['name']}}</b></p>
				<hr  style="margin:0px; padding: 0px;">
				<p class="text-center">{{$wali['nik']}}</p>
			</div>
		@endforeach
	</div>
	@endforeach
	<style type="text/css">
		
		.panel{
			border-right:1px solid #000;
			border-top:1px solid #000;

		}
	</style>

@stop
