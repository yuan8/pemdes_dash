@extends('vendor.adminlte.dashboard')

@section('content_header')
	@include('partials.banner_head')
@stop

@section('content')

<div class="container" style="">
	<div class="col-md-6">
		<h1 style="line-height:26px; margin-top:7px;">Sumber <b>Data</b></h1>
		<div class="row">
			<div class="col-md-6">
				<div class="box box-solid btn-ov box-shadows-blue">
					<div class="box-body">
						<h1 style="line-height:26px; margin-top:7px;">67,78%</h1>
						<p class="background-primary btn-ov text-white f-10" style="padding:10px;">Data Desa Kelurahan Telah entri data di Sistem Prodeskel</p>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box box-solid btn-ov box-shadows-blue">
					<div class="box-body">
						<h1 style="line-height:26px; margin-top:7px;">67,78%</h1>
						<p class="background-primary btn-ov text-white f-10" style="padding:10px;">Data Desa Kelurahan Telah entri data di Sistem Prodeskel</p>
					</div>
				</div>
			</div>
		</div>
	<h1 style="line-height:26px; margin-top:7px;">Klasifikasi <b>Desa</b></h1>
		<div class="row">
			<div class="col-md-4">
				<div class="box box-danger btn-ov">
					<div class="box-body">
						<h1 style="line-height:26px; margin-top:7px;">67,78%</h1>
						<p class="background-primary btn-ov text-white f-10" style="padding:10px;">Data Desa Kelurahan Telah entri data di Sistem Prodeskel</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-warning btn-ov">
					<div class="box-body">
						<h1 style="line-height:26px; margin-top:7px;">67,78%</h1>
						<p class="background-primary btn-ov text-white f-10" style="padding:10px;">Data Desa Kelurahan Telah entri data di Sistem Prodeskel</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-success btn-ov">
					<div class="box-body">
						<h1 style="line-height:26px; margin-top:7px;">67,78%</h1>
						<p class="background-primary btn-ov text-white f-10" style="padding:10px;">Data Desa Kelurahan Telah entri data di Sistem Prodeskel</p>
					</div>
				</div>
			</div>
		</div>
		<p class="text-primary">* Sumber Data <a href="http://http://prodeskel.binapemdes.kemendagri.go.id/" class="text-primary"><b>prodeskel.binapemdes.kemendagri.go.id</b></a></p>
		<div class="row">
			<div class="col-md-4">
				<div class="box box-danger btn-ov">
					<div class="box-body">
						<h1 style="line-height:26px; margin-top:7px;">67,78%</h1>
						<p class="background-primary btn-ov text-white f-10" style="padding:10px;">Data Desa Kelurahan Telah entri data di Sistem Prodeskel</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-warning btn-ov">
					<div class="box-body">
						<h1 style="line-height:26px; margin-top:7px;">67,78%</h1>
						<p class="background-primary btn-ov text-white f-10" style="padding:10px;">Data Desa Kelurahan Telah entri data di Sistem Prodeskel</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-success btn-ov">
					<div class="box-body">
						<h1 style="line-height:26px; margin-top:7px;">67,78%</h1>
						<p class="background-primary btn-ov text-white f-10" style="padding:10px;">Data Desa Kelurahan Telah entri data di Sistem Prodeskel</p>
					</div>
				</div>
			</div>
		</div>
		<p class="text-primary">* Sumber Data <a href="http://http://epdeskel.binapemdes.kemendagri.go.id/" class="text-primary"><b>epdeskel.binapemdes.kemendagri.go.id</b></a></p>

	</div>
	<div class="col-md-6" style="padding-left:27px;">
	<h3 class="text-center "><b>DATA UTAMA </b></h3>
		<div class="owl-carousel owl-theme btn-ov bg-slider-1">
	  	@foreach($tema as $t)
	  	<div class="item text-center" >
				<a   href="{{route(($t->route??'index'),['tahun'=>$GLOBALS['tahun_access'],'id'=>$t->id,'slug'=>HPV::slugify($t->name)])}}" class="text-center hover-scale"  style="position:relative; width:100%; float:left;" >
							<p><b>{{$t->name}}</b></p>

					<img data-toggle="tooltip" data-placement="top" title="" src="{{asset($t->image_path)}}" class="img-center img1 text-center point-hover" data-original-title="Pariwisata &amp; Kebudayaan">
				</a>

	    </div>

	  	@endforeach

		</div>
	<h3 class="text-center "><b>DATA PENDUKUNG</b></h3>
		
		<div class="owl-carousel owl-theme bg-slider-2 btn-ov">
	  	@foreach($tema2 as $t)
	  	<div class="item text-center" >
				<a href="{{route(($t->route??'index'),['tahun'=>$GLOBALS['tahun_access'],'id'=>$t->id,'slug'=>HPV::slugify($t->name)])}}" class="text-center hover-scale"  style="position:relative; width:100%; float:left;" >
						<p><b>{{$t->name}}</b></p>

					<img data-toggle="tooltip" data-placement="top" title="" src="{{asset($t->image_path)}}" class="img-center img1 text-center point-hover" data-original-title="Pariwisata &amp; Kebudayaan">
				</a>

	    </div>

	  	@endforeach

		</div>
	</div>
</div>

<div class="container" style="">
	<div class="col-md-8 col-md-offset-2">
		
	</div>
</div>

{{-- <div class="row background-img-box">
	<div class="col-md-12">
		<h4 class="text-center text-white"><b>STATISTIK DATA</b></h4>

	</div>
	<div class="container">
		<div class="col-md-3">
		<div class="box box-solid">
			<div class="box-body">

				<h3>3000 <small>P</small></h3>

			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-solid">
			<div class="box-body">

				<h3>3000 <small>P</small></h3>

			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-solid">
			<div class="box-body">

				<h3>3000 <small>P</small></h3>

			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-solid">
			<div class="box-body">

				<h3>3000 <small>P</small></h3>

			</div>
		</div>
	</div>
	</div>
	
</div> --}}
@stop

@section('js')

<script type="text/javascript" src="{{url('vendor/OwlCarousel/dist/owl.carousel.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{url('vendor/OwlCarousel/dist/assets/owl.carousel.min.css')}}">

<style type="text/css">
.owl-nav{
	height: 0px;
}


</style>
<script type="text/javascript">



	$(document).ready(function(){
			$(".owl-carousel").owlCarousel({
		 		smartSpeed : 450,
		 		navText:["<div class='nav-btn prev-slide'><i class='fa fa-chevron-left fa-3x text-primary opacity-50'></i></div>","<div class='nav-btn next-slide'><i class='fa fa-chevron-right fa-3x text-primary opacity-50'></i></div>"],
		 		lazyload : true,
		 		loop : true,
		 		items : 3,
		 		dots : false,
		 		responsiveClass:true,
			    responsive:{
			        0:{
			            items:1,
			            nav:true
			        },
			        600:{
			            items:3,
			            nav:true
			        },
			       
			    }
			});

	});
</script>
@stop
