
		<h3 class="text-center "><b>{{$kecamatan['nama']}} TAHUN {{$tahun}}</b></h3>
		<p class="text-center"><small>{{$kecamatan['nmkota']}} - {{$kecamatan['nmprovinsi']}}</small></p>
		<p class="text-center">{{Carbon\Carbon::parse($now)->format('d F Y')}}</p>
		<h4 class=""><b>LEMBAR DATA - {{strtoupper($table_map['data_name'])}}</b></h4>
		
		
		<table class="table table-bordered bg-gray">
			<tr>
				<th>
					<h5>JUMLAH DESA</h5>
						<p><b>{{HPV::nformat($kecamatan['jumlah_desa'])}} Desa</b></p>
				</th>
				<th>
					<h5>JUMLAH DESA TERDATA</h5>
						<p><b>{{HPV::nformat($kecamatan['jumlah_data'])}} Desa</b></p>
				</th>
				<th>
					<h5>PERSENTASE PELAPORAN</h5>
						<p><b>{{HPV::nformat($kecamatan['persentase_pelaporan'])}} %</b></p>
				</th>

			</tr>
		</table>

		@foreach ($table_map['split_col'] as $col)
			<table class="table table-bordered tdata ">
				<thead>
					<tr>
						<th style="width:35px;" rowspan="2">NO</th>
						<th rowspan="2" style="min-width: 60px">KODEDESA</th>
						<th rowspan="2" style="min-width: 60px">NAMA DESA</th>
						<th rowspan="2" style="min-width: 60px">STATUS DESA</th>
						@foreach ($col as $d)
							<th colspan="2" style="min-width: 7.1%">{{$d['name']}}</th>
						@endforeach
					</tr>
					<tr>
						@foreach ($col as $d)
							<th >SATUAN</th>
							<th >NILAI</th>
						@endforeach
						
					</tr>
				</thead>
				<tbody>
					@php
						$index=0;
					@endphp
					@foreach ($kecamatan['data'] as $d)
					@php
						$index++;	
						$d=(array)($d);
					@endphp
						<tr>
							<td >{{$index}}</td>
							<td >{{$d['id']}}</td>
							<td >{{$d['name']}}</td>
							<td >{{$d['status_desa']}}</td>
							@foreach ($col as $dx)
								<td style="width:3.55%" >{{$d[$dx['flag'].'_satuan']}}</td>
								<td style="width:3.55%"  >{{$d[$dx['flag']]}}</td>
							@endforeach

						</tr>
						{{-- expr --}}
					@endforeach
					
				</tbody>
			</table>
			
		@endforeach
	{{-- <h3 class="text-center "><b>{{$kecamatan['nama']}} TAHUN {{$tahun}}</b></h3>
	<h4 class=""><b>2. LEMBAR PENGESAHAN  {{strtoupper($table_map['data_name'])}}</b></h4>
	<p class="text-right">{{$kecamatan['nama']}},........,...............,{{$GLOBALS['tahun_access']}}</p>
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
	</div> --}}



