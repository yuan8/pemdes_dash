@extends('vendor.adminlte.dashboard')

@section('menu')	
	{{-- <ul>
		<li>
			<button>AUTHENTIFIKASI </button>
		</li> --}}
		

@stop

@section('content')
	<div id="mySidenav" class="sidenav" style="margin-top: 70px;">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  @foreach($data as $d)
	<a href="javascript:void(0)" onclick="scrollToDOM('#dokumentasi-{{$d->id}}')">{{$d->name }} ({{$d->id}})</a>
	@endforeach
</div>

	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="javascript:void(0)" onclick="openNav()">
	      	<i class="fa fa-hamburger"></i> Menu
	      </a>
	    </div>
	  </div>
	</nav>

	<div class="container-fluid">
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

	</div>
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

<style type="text/css">
	/* The side navigation menu */
.sidenav {
  height: 100%; /* 100% Full-height */
  width: 0; /* 0 width - change this with JavaScript */
  position: fixed; /* Stay in place */
  z-index: 1; /* Stay on top */
  top: 0; /* Stay at the top */
  left: 0;
  background-color: #111; /* Black*/
  overflow-x: hidden; /* Disable horizontal scroll */
  padding-top: 60px; /* Place content 60px from the top */
  transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
}

/* The navigation menu links */
.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 10px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

/* When you mouse over the navigation links, change their color */
.sidenav a:hover {
  color: #f1f1f1;
}

/* Position and style the close button (top right corner) */
.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#main {
  transition: margin-left .5s;
  padding: 20px;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 10px;}
}
</style>

<script type="text/javascript">
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
}
</script>
@stop

