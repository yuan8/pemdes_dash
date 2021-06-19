@extends('layouts.export')

@section('content')

</script>
	
	<div class="logo_export"></div>
	<h3 class="text-center">LEMBAR PENGESAHAN {{strtoupper($table_map['data_name'])}}</h3>
	<p class="text-center">{{isset($rekap['daerah'])?$rekap['daerah']:''}} TAHUN {{$tahun}}</p>
	<hr>
	@php
		
		// dd($rekap);
	@endphp
	<br>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DENGAN INI MENYATAKAN DATA TERKAIT <b>{{strtoupper(isset($rekap['nama_data'])?$rekap['nama_data']:'')}}</b> TELAH MELALUI PROSES <b>VERIFIKASI</b> DAN <b>VALIDASI</b> DARI TINGKAT <b>DESA/KEL</b>,<b>KECAMATAN</b> HINGGA <b>KOTA/KABUPATEN</b> DENGAN DIIKUTI OLEH <b>{{isset($rekap['rekap_desa'])?HPV::nformat($rekap['rekap_desa']['melapor']):''}} / {{isset($rekap['rekap_desa'])?HPV::nformat($rekap['rekap_desa']['total']):''}}</b> DESA/KEL, DARI <b> {{isset($rekap['rekap_desa'] )?HPV::nformat($rekap['rekap_kecamatan']['melapor']):''}} / {{isset($rekap['rekap_desa'] )?HPV::nformat($rekap['rekap_kecamatan']['total']):''}} </b> KECAMATAN TERDAFTAR</p>
	<br>
	<br>

	<p class="text-uppercase text-right">{{isset($rekap['daerah'])?$rekap['daerah']:''}},{{Carbon\Carbon::now()->format('d / m / Y')}}</p>
	<p class="text-center"><b>Mengetahui</b></p>
	<br>
@php
	$peserta=$peserta??[];
	$peserta=array_chunk($peserta,5);


@endphp
	<table>
			@foreach ($peserta as $col)
					<tr>

				@foreach ($col as $p)
					{{-- expr --}}
					<td class="text-center">
						<p style="margin-bottom: 60px;">{{$p->head}}</p>
						<p><b><u>{{$p->name}}</u></b></p>
						<p>{{$p->nip}}</p>

					</td>

						
				@endforeach
				</tr>
				<tr>
					<td style="min-height: 20px;" colspan="{{isset($peserta[0])?count($peserta[0]):1}}">
						<div style="min-height: 1000px">
							<br>
						</div>
					</td>
				</tr>

		
			@endforeach

	</table>

<script type="text/php">
    if (isset($pdf)) {
    	{{-- dd($pdf->get_height()); --}}
    	$HEIGH=$pdf->get_height();
        $x =50;
        $y = 20;
        $text = "Lembar Pengesahan Halaman {PAGE_NUM} / {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>
	

@stop