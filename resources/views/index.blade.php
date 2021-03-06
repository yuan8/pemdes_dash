@extends('vendor.adminlte.dashboard')

@section('content_header')
	@include('partials.banner_head')
@stop

@section('content')

<div class="container" style="">
	<div class="col-md-6">
		<div id="klasifikasi_content">
			
			<h1 class="text-center"><b>Loading...</b></h1>
		</div>
		
		
	</div>
	<div class="col-md-6" style="padding-left:27px;">
	<h3 class="text-center "><b>DATA UTAMA </b></h3>
		<div class="owl-carousel owl-theme  bg-slider-1">
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
		
		<div class="owl-carousel owl-theme bg-slider-2 ">
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
	$.get('{{route('re.cat.cat_desa',['tahun'=>$GLOBALS['tahun_access']])}}',function(res){
		// res=JSON.parse(res);

		if(res.status==200){
			$('#klasifikasi_content').html(res.data);
		}
	});


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
