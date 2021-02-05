@extends('vendor.adminlte.dashboard')

@section('content_header')

@stop
@section('content')
<div class="banner-content text-center p-10 p-b-50" style="position: relative; background:linear-gradient(163deg, rgba(146,146,232,1) 17%, rgba(51,122,183,1) 52%, rgba(42,67,111,1) 88%); min-height: 100px; margin-bottom: 50px;">
	<ol class="breadcrumb text-left">
    <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active text-capitalize">{{ strtolower((!empty($instansi)) ?str_replace('_PRIMER','',str_replace('_SEKUNDER', '', $instansi->type)).' - '.$instansi->name:(isset($title)?$title:'Cari Data'))}}</li>
  </ol>


	@if(isset($instansi))
		<h3 class="text-white"><b>{{str_replace('_PRIMER','',str_replace('_SEKUNDER', '', $instansi->type))}} - {{$instansi->name}}</b></h3>
	@endif

	@if(isset($title))
		<h3 class="text-white"><b>{{$title}}</b></h3>
	@endif
	
	<div  style="left:0; right: 0; margin:auto; height: 55px; width: 90%; position: absolute; bottom:-30px; ">
		<form action="{{url()->current()}}" method="get">
			<div class="input-group" style="border: 2px solid #6db3ee;border-radius: 30px; overflow: hidden; ">
      <input type="text" class="form-control" name="q" value="{{$request->q}}" placeholder="Cari {{isset($title)?strtolower($title):'Data'}}" style="height: 55px;">
      <span class="input-group-btn">
        <button class="btn btn-primary" type="submit" style="height: 55px; min-width: 100px;"><i class="fa fa-search"></i></button>
      </span>
    </div>
		</form>
		
	</div>

	</div>

<div class="container">
	<div class="row">

	
		@foreach($data as $d)
	<div class="col-md-4">

			<div class="box ">
            
            <div class="box-body">
            	<img class="text-center img-responsive" src="{{asset($d->image_path)}}">
              <span class="info-box-text">
              	<a href="{{route('query.data.categorycal',['id'=>$d->id,HPV::slugify($d->name)])}}">{{$d->name}}</a>
              </span>
             
             
            </div>
            <!-- /.info-box-content -->
          </div>
			</div>
		@endforeach

		@if(count($data)<1)
			<h5 class="text-center"><b>BELUM TERDAPAT DATA ORGANISASI</b></h5>
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