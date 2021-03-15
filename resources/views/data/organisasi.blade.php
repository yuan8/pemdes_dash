@extends('vendor.adminlte.dashboard')

@section('content_header')
<div class="row">
	<div class="col-md-12">
	<ol class="breadcrumb text-left">
	    <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
	    <li class="active text-capitalize">{{ strtolower((!empty($instansi)) ?str_replace('_',' ',str_replace('_', ' ', $instansi->type)).' - '.$instansi->name:(isset($title)?$title:'Cari Data'))}}</li>
	  </ol>
  </div>


</div>
	@include('partials.banner_head',['route_search'=>url()->full(),'placeholder_search'=>ucfirst(strtolower((isset($instansi)?($instansi->type):$title)))])
@stop
@section('content')

	@if(isset($instansi))
		<h3 class="text-center"><b>{{str_replace('_PRIMER','',str_replace('_SEKUNDER', '', $instansi->type))}} - {{$instansi->name}}</b></h3>
	@endif

	@if(isset($title))
		<h3 class="text-center"><b>{{$title}}</b></h3>
	@endif

<div class="container">
	<div class="row">

	
		@foreach($data as $d)
	<div class="col-md-2 text-center " style="min-height: 100px; border-bottom: 3px solid  #222; margin-top: 20px;">
			<a class="organisasi-hover" href="{{route('query.data.categorycal',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,HPV::slugify($d->name)])}}">
			<div class=" box-shadows-gray xx background-blue-y border-gray" style="width:50px; height: 50px;  overflow: hidden; position: absolute;  margin:auto; left:0; right:0; ">
				<div class="box-header  text-center" style="height: 50px; overflow: hidden; vertical-align: middle;">
					<img class="point-hover" src="{{asset($d->image_path)}}" style="max-height: 50px; width:auto; position: absolute; margin: auto; top:0;left:0;bottom: 0; right: 0;">
				</div>

          </div>
              <h5 class="text-center one-line" style="padding-top: 55px;"><b >{{strtoupper($d->name)}}</b></h5>

          </a>
			</div>
		@endforeach

		@if(count($data)<1)
			<h5 class="text-center"><b>BELUM TERDAPAT DATA INSTANSI "{{$request->q}}"</b></h5>
		@endif
	</div>
		{{$data->links()}}

</div>

@stop

@section('js')

	<style type="text/css">
		.c-fix{
			position: relative;
		}

		.affix.c-fix{
			position: fixed;
			z-index: 2;
			top:55px;
		}
	</style>

	<script type="text/javascript">
	console.log('run');

		$(function(){
			setTimeout(function(){
			$('.affix, .affix-top').each(function(i,d){
				$(d).css('width',$(d)[0].with);
			});
			},500);
		})


	</script>
@stop