@php
	$conf_colors=['bg-red','bg-yellow','bg-green','bg-blue'];
@endphp
<h1 style="line-height:26px; margin-top:7px;">Sumber <b>Data</b></h1>
<div class="row">
@foreach($data as $d)
@php
	$re=$d['rekap'];
@endphp
<div class="col-md-6">
				<div class="box box-solid btn-ov box-shadows-blue  hover-cat">
					<div class="box-body">
						<p style="font-size: 20px;" class="angka"><b>{{HPV::nformat($re['count'])}} Desa</b></p>
						<h1  class="persentase" style="line-height:26px; margin-top:7px;">
							{{number_format((($re['count']) and ($re['jumlah_desa']))?(((float)$re['count']/(float)$re['jumlah_desa'])*100):0,2,'.',',')}} %


						</h1>
						<p class="background-primary btn-ov text-white f-10" style="padding:10px;">Desa Kelurahan Telah entri data di Sistem {{$d['name']}}</p>
						
					</div>
				</div>
			</div>
@endforeach
</div>

<h1 style="line-height:26px; margin-top:7px;">Klasifikasi <b>Desa/Kelurahan</b></h1>
@foreach($data as $d)
<div class="row">
	@foreach($d['data'] as $key=>$k)
		<div class="col-md-4">
				<a href="">
					<div class="box box-solid {{$conf_colors[$key]}} btn-ov box-b-gray hover-cat">
					<div class="box-header {{$conf_colors[$key]}} ">
						<h5><b>{{$k['klasifikasi']}}</b></h5>
					</div>
					<div class="box-body">
						<p class="angka"><b>{{HPV::nformat($k['count'])}} Desa</b></p>
						<h1  class="persentase" style="line-height:26px; margin-top:7px;">
							{{number_format((($k['count']) and ($k['jumlah_desa']))?(((float)$k['count']/(float)$k['jumlah_desa'])*100):0,2,'.',',')}} %


						</h1>

						
	
					</div>
				</div>
				</a>
			</div>
	@endforeach
</div>
<p class="text-primary">* Sumber Data <a href="{{$d['link']}}" class="text-primary"><b>{{$d['name']}}</b></a></p>

@endforeach

<style type="text/css">
	.hover-cat:hover .angka{
		display: block;
	}
	.hover-cat:hover .persentase{
		display: none;
	}

	.hover-cat .angka{
		display: none;
	}

</style>