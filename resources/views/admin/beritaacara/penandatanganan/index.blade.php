@extends('vendor.adminlte.admin')
@section('content_header')
<h4>REKAP DATA TAHUN {{$GLOBALS['tahun_access']}} </h4>
@stop

@section('content')
<div class="box box-solid">
	<div class="box-header with-border">
		<p>
			<span><i class="fa fa-circle" style=" color:gray;"></i></span> TOTAL DESA
			<span><i class="fa fa-circle" style=" color:#00a65a;"></i></span> DATA VALID
			<span><i class="fa fa-circle" style=" color:#f39c12;"></i></span> VER KEC.
			<span><i class="fa fa-circle" style=" color:maroon;"></i></span> VER DESA


		</p>
	</div>
	<div class="box-body">

		<table class="table table-bordered" id="table-berita-acara">
			<thead>
				<tr>
					<th>NO</th>
					<th>DATA</th>
					<th>BERKAS DATA</th>
					<th>BERKAS PENGESAHAN</th>
					<th>STATUS</th>
					<th>KONDISI DATA</th>
					<th>AKSI</th>

				</tr>
			</thead>
			<tbody>
				@foreach ($data as $key=> $d)
					{{-- expr --}}

					<tr>
						<td>{{$key+1}}</td>
						<td>{{$d->nama_data}}</td>
						@php
							// dd($d);
						@endphp
						<td>
							@if($d->path_berita_acara)
							<a target="_blank" href="{{asset($d->path_berita_acara)}}" class="btn btn-xs btn-primary">Data Berita Acara</a>
							@else
							Belum Terdapat Data

							@endif
						</td>
						<td></td>
						<td></td>

						<td style="min-width: 200px;">
							<p>TEHIMPUN DARI {{HPV::nformat($d->rekap_real['jum_kec_l'])}} / {{HPV::nformat($d->total_kec)}} KECAMATAN</p>
						<div style="width:100%">
							<div  class="text-center" style="width:100%; color:#fff; height:12px; overflow: hidden; background: gray;">
								<small >{{HPV::nformat($d->total_des)}} Desa</small>
							</div>
						</div>	
						<div style="width:100%" class="text-center">
							<div style="width:{{100*$d->rekap_real['kat_5']/$d->total_des}}%; color:#fff; height:12px; overflow: hidden; background: #00a65a;">
								<small >{{HPV::nformat($d->rekap_real['kat_5'])}} Desa</small>
								
							</div>
						</div>
						<div style="width:100%" class="text-center">
							<div style="width:{{100*$d->rekap_real['kat_3']/$d->total_des}}%; height:12px; overflow: hidden; background: #f39c12; ">
								<small >{{HPV::nformat($d->rekap_real['kat_3'])}} Desa</small>
								
							</div>
						</div>
						<div style="width:100%" class="text-center">
							<div style="color:#fff; width:{{100*$d->rekap_real['kat_2']/$d->total_des}}%; height:12px; overflow: hidden; background: maroon; ">
								<small >{{HPV::nformat($d->rekap_real['kat_2'])}} Desa</small>
								
							</div>
						</div>	
						</td>
						<td>
							<a href="{{route('a.b.r.edit',['tahun'=>$GLOBALS['tahun_access'],'kode_daerah'=>Auth::User()->kode_daerah,'id'=>$d->id_data])}}" class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> Edit</a>
						</td>


					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>



@stop

@section('js')
<script type="text/javascript">
	$('#table-berita-acara').dataTable();
</script>
@stop