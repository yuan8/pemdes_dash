@extends('layouts.export')

@section('content')
	
	<div class="logo_export"></div>

	<h2 class="text-center" style="margin:2px;">BERITA ACARA  {{strtoupper($table_map['data_name'])}} TAHUN {{$tahun}}</h2>
	<h3 class="text-center" style="margin:2px;">{{strtoupper($daerah['nama_daerah'])}}</h3>
	<p class="text-center">{{Carbon\Carbon::parse($now)->format('d F Y')}}</p>
	<hr>
	<h3><b>REKAP KECAMATAN PELAPOR</b></h3>
	<table class="table tdata table-bordered">
		@php
			$col_kecamatan=$kecamatan_series;
			$index_kc=0;
			$index_length=isset($col_kecamatan[0])?count($col_kecamatan[0]):1;
		@endphp
		<tr >
			<th colspan="{{$index_length*3}}">JUMLAH KECAMATAN  MELAPOR {{HPV::nformat(count($data['data']))}} / {{HPV::nformat($count_kecamatan)}}</th>
			
		</tr>
		<tr>
			@for ($i = 0; $i <$index_length ; $i++)
				<th>NO</th>
				<th>NAMA</th>
				<th>DESA <span style="color:green" >MELAPOR</span> / <span style="color:maroon"  >TIDAK MELAPOR</span></th>
			@endfor

		</tr>
		@foreach ($col_kecamatan as $ky_g=> $kc_g)
			<tr>
				@foreach ($kc_g as $ky_c=> $kc)
				@php
					$index_kc++;
				@endphp
					<td style="width:30px;">{{$ky_c>0?(($ky_g*$ky_c)+1+count($col_kecamatan)):$ky_g+1}}</td>
					<td style="width:100px;">{{$kc['name']}}</td>
					<td>
						<div style="width:100%;background: #f1f1f1; ">
							<div class="text-center" style="color:#fff; overflow: hidden;  height:12px; width:{{100*$kc['data'][1]['y']/$kc['data'][0]['y']}}%; background: green" >
							{{$kc['data'][1]['y']}} / {{$kc['data'][0]['y']}} Total Desa
							</div>
						</div>
						<div style="width:100%; background: #f1f1f1;">
							<div class="text-center" style="color:#fff;height:12px; overflow: hidden; width:{{100*$kc['data'][2]['y']/$kc['data'][0]['y']}}%; background: maroon" >
								{{$kc['data'][2]['y']}} / {{$kc['data'][0]['y']}}  Total Desa
						</div>
						</div>
					
					</td>
				@endforeach

			</tr>
			{{-- expr --}}
		@endforeach
	</table>
	<h3>METADATA - {{strtoupper($table_map['data_name'])}}</h3>
	<table class="table table-bordered tdata ">
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
	
	@if(!isset($only_rekap))

		@if(count($data['data']))
			<p class="break-print"></p>
		@endif
		@php
			$c_=count($data['data']);
			$c_i=0;
		@endphp
		@foreach ($data['data'] as $kecamatan)
			@php
			$c_i++;
				$kecamatan=(array)$kecamatan;
			@endphp
			@include('admin.beritaacara.buat.per_kecamatan',['kecamatan'=>$kecamatan])
			
			@if(($c_i+1)<$c_)
				<p class="break-print"></p>
				
			@endif
		@endforeach

	@endif


		
		
	</style>

@stop
