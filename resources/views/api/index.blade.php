@extends('layouts.dokumentasi.master')

@section('menu')	
	{{-- <ul>
		<li>
			<button>AUTHENTIFIKASI </button>
		</li> --}}
		@foreach($data as $d)
	<a href="javascript:void(0)" onclick="scrollToDOM('#dokumentasi-{{$d->id}}')">{{$d->name }} ({{$d->id}})</a>
	@endforeach

@stop

@section('content')
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="javascript:void(0)" onclick="openNav()">
	      	<i class="fa fa-hamburger"></i> Menu
	      </a>
	    </div>
	  </div>
	</nav>

	<div id="dokumentasi-desa">
			<h5><b class="text-uppercase">TABLE DAERAH</b></h5>

			<div class="table table-responsive">
				<table class="table-bordered table">
					<thead>
						<tr>
							<th colspan="3">DESA</th>
							<th colspan="2">KECAMATAN</th>
							<th colspan="2">KOTA/KAB</th>
							<th colspan="2">PROVINSI</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($desa as $d)
							<tr>
								<td>{{$d->kode_dagri}}</td>
								<td>{{$d->desa}}</td>
								<td>{{$d->desa}}</td>


							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
	</div>
	<hr>

	<div id="dokumentasi-authorization">
			<h5><b class="text-uppercase">Authorization</b></h5>

		<div class="bg-success" style="padding:10px; border-radius: 5px; margin-top: 10px; margin-bottom: 10px;">
			<p>
				
			</p>
			
		</div>
<pre>{
	"headers": {
		"authorization": "Bearer <span>{API_TOKEN}</span>",
		"content-type": "application/json",
		"cache-control": "no-cache"
	}
}</pre>
			
	</div>
	<hr>

	<div id="dokumentasi-schedule">
			<h5><b class="text-uppercase">JADWAL PENGAMBILAN DATA</b></h5>

		<div class="bg-success" style="padding:10px; border-radius: 5px; margin-top: 10px; margin-bottom: 10px;">
			<p>
				Dalam Pengaksesan Data Melalui API Hanya Dapat Dilakukan Pada {{Carbon\Carbon::now()->startOfDay()->addHours(-1)->addMinutes(15)->format('h:i a')}} Hingga  {{Carbon\Carbon::now()->endOfDay()->addHours(3)->addMinutes(-15)->format('h:i a')}}
			</p>
			
		</div>
	</div>
	<hr>

	<div id="dokumentasi-authorization">
			<h5><b class="text-uppercase">PAYLOAD STUKTUR</b></h5>

		<div class="bg-success" style="padding:10px; border-radius: 5px; margin-top: 10px; margin-bottom: 10px;">
			<p>
				
			</p>
			
		</div>
			<pre>{
    "status": 500, <span>// Kode Status Hasil Pengambilan Data</span>
    "status_text": "Fail", <span>// Status Pengambilan Data</span>
    "message": { <span>// Pesan Server</span>
        "kodedaerah": [
            "The kodedaerah must be at least 2 characters."
        ]
    },
    "filters": [],
    "access_user_meta": { <span>// Data Agen Yang Digunakan Untuk Akses Data</span>
        "name": "user a",
        "email": "mail@domain.com",
    },
    "schedule": { <span>// Keterangan Jadwal Pengambilan Data dan Izin Akses</span>
        "grand_access": true,
        "start": "2021-04-06 22:09:59",
        "end": "2021-04-07 03:49:59"
    },
    "meta": { <span>// Keterangan Jenis Data Yang Diambil</span> 
        "id_data": 2702920920,
        "nama": "Data Musrembang Desa",
        "tahun": 2020,
        "check_sum": "2021-04-05 04:19:34" <span>// Tanggal Data Terahir Diperbarui</span>
    },
    "count_data": 0, <span>// Jumlah Data Desa Yang Berhasil Diambil</span>
    "data": [  <span>// Data Desa</span>
        {
            "kode_desa": "1101102009",
            "nama_desa": "UJONG BATEE",
            "data": [
                {
                    "name": "musrembang",
                    "key_c": "jumlah_musrenbangdes",
                    "satuan": "-",
                    "definisi": null,
                    "tipe_data": null,
                    "interval_nilai": null,
                    "value_data": 2
                },
                {
                    "name": "Peserta Pria",
                    "key_c": "jumlah_peserta_pria",
                    "satuan": "Jiwa",
                    "definisi": null,
                    "tipe_data": null,
                    "interval_nilai": null,
                    "value_data": 30
                },
                ........................
    ]
}</pre>
			
	</div>
	<hr>
	@foreach($data as $d)
		<div id="dokumentasi-{{$d->id}}">
			<h5><b>{{$d->name}}</b></h5>
			<div class="btn-group" style="margin-bottom: 10px;">
				<button class="btn btn-primary btn-xs " disabled="">POST</button>
			<button class="btn btn-default btn-xs" disabled="">{!!str_replace('xx','<code>{',str_replace('|x|', '}</code>',route('api.public.getdata',['tahun'=>'xxtahun|x|','id'=>$d->id,'kodedaerah'=>'xxkodedaerah|x|'])))!!} </button>
			</div>	
			<div class="bg-success" style="padding:10px; border-radius: 5px; margin-top: 10px; margin-bottom: 10px;">
			<p ><b>Deskripsi</b></p>
			<p>{!!nl2br($d->description)!!}</p>
			</div>

			<div class="table-responsive" style="margin-bottom: 10px;">
				<table class="table table-bordered">
				<thead>
					<tr>
						@foreach($d->map_column as $m)
							<th colspan="3" class="text-capitalize">{{strtolower($m->name)}}</th>
						@endforeach
					</tr>
					<tr>
						@foreach($d->map_column as $m)
							<th colspan="1" class="bg-primary">Definisi/Konsep</th>
							<th colspan="1" class="bg-primary">Satuan</th>
							<th colspan="1" class="bg-primary">Key</th>


						@endforeach
						
					</tr>
				</thead>
				<tbody>
					@foreach($d->map_column as $m)
							<td colspan="1" >{{strtolower($m->definisi)}}</th>
							<td colspan="1">{{strtolower($m->satuan)}}</td>
							<td colspan="1">{{strtolower($m->name_column)}}</td>

					@endforeach
				</tbody>
			</table>
			</div>
			
			
			

		</div>
		<hr>
	@endforeach

	<style type="text/css">
		table th, td{
			font-size: 10px!important;
		}
		pre {
			color:green;
		}
		pre span {
			color: #222;
			font-weight: bold;
		}
	</style>
@stop

@section('js')
<script type="text/javascript">
	function scrollToDOM(dom){
       setTimeout(function(){
         $('html,body').animate({
            scrollTop: $(dom).offset().top!=undefined?$(dom).offset().top:0
        }, 2000);
       },100);
      }

</script>
@stop

