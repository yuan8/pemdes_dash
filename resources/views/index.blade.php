@extends('vendor.adminlte.dashboard')


@section('content')
<div class="banner-content text-center p-10 p-b-50" style="position: relative; background:linear-gradient(163deg, rgba(146,146,232,1) 17%, rgba(51,122,183,1) 52%, rgba(42,67,111,1) 88%); min-height: 100px; margin-bottom: 50px;">

	<p class="text-white"><b>SELAMAT DATANG DI DASHBOARD</b></p>
	<h3 class="text-white"><b>BINA PEMERINTAHAN DESA</b></h3>
	<p class="text-white text-uppercase">Kementerian Dalam Negeri</p>

	<div  style="left:0; right: 0; margin:auto; height: 55px; width: 90%; position: absolute; bottom:-30px; ">
		<form action="{{route('query.data',[])}}" method="get">
			<div class="input-group" style="border: 2px solid #6db3ee;border-radius: 30px; overflow: hidden; ">
      <input type="text" class="form-control" name="q" placeholder="Cari Data,Tema,Instansi" style="height: 55px;">
      <span class="input-group-btn">
        <button class="btn btn-primary" type="submit" style="height: 55px; min-width: 100px;"><i class="fa fa-search"></i></button>
      </span>
    </div>
		</form>

	</div>

	</div>
<div class="container" style="">
	<h3 class="text-center text-primary"><b>TELURUSI BERDASARKAN GROUP TOPIK </b></h3>
	<div class="col-md-8 col-md-offset-2">
		<div class="owl-carousel owl-theme">
	  	@foreach($tema as $t)
	  	<div class="item text-center" >
				<a href="{{route(($t->source_direct??'index'),['id'=>$t->id,'slug'=>'slug-test'])}}" class="text-center"  style="position:relative; width:100%; float:left;" >
					<div class="box box-solid" >
						<div class="box-body" style="min-height:180px;">
							<img data-toggle="tooltip" data-placement="top" title="" src="{{$t->image_path}}" class="img-center img1 text-center" data-original-title="Pariwisata &amp; Kebudayaan">
							<p><b>{{$t->name}}</b></p>

						</div>

					</div>
				</a>

	    </div>

	  	@endforeach

		</div>
	</div>
</div>

<div class="container" style="">
	<h3 class="text-center text-primary"><b>TELURUSI BERDASARKAN GROUP TOPIK</b></h3>
	<div class="col-md-8 col-md-offset-2">
		<div class="owl-carousel owl-theme">
	  	@foreach($tema as $t)
	  	<div class="item text-center" >
				<a href="{{route(($t->source_direct??'index'),['id'=>$t->id,'slug'=>'slug-test'])}}" class="text-center"  style="position:relative; width:100%; float:left;" >
					<div class="box box-solid" >
						<div class="box-body" style="min-height:180px;">
							<img data-toggle="tooltip" data-placement="top" title="" src="{{$t->image_path}}" class="img-center img1 text-center" data-original-title="Pariwisata &amp; Kebudayaan">
							<p><b>{{$t->name}}</b></p>

						</div>

					</div>
				</a>

	    </div>

	  	@endforeach

		</div>
	</div>
</div>
@stop

@section('js')

<script type="text/javascript" src="{{url('vendor/OwlCarousel/dist/owl.carousel.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{url('vendor/OwlCarousel/dist/assets/owl.carousel.min.css')}}">

<style type="text/css">



</style>
<script type="text/javascript">



	$(document).ready(function(){
			$(".owl-carousel").owlCarousel({
		 		smartSpeed : 450,
		 		nav : true,
		 		navText:["<div class='nav-btn prev-slide'><i class='fa fa-chevron-left fa-3x text-primary opacity-50'></i></div>","<div class='nav-btn next-slide'><i class='fa fa-chevron-right fa-3x text-primary opacity-50'></i></div>"],
		 		lazyload : true,
		 		loop : true,
		 		items : 5,
		 		dots : true,
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
			        1000:{
			            items:5,
			            nav:true,
			        }
			    }
			});

	});
</script>
@stop
