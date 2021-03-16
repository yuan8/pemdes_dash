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
	@include('partials.banner_head',['placeholder_search'=>'Cari Data '.(isset($instansi)?ucfirst(strtolower($instansi->type)).' '.ucfirst(strtolower($instansi->name)):', Instansi, Tema'),'route_search'=>url()->full()])
@stop
@section('content')

<div class="row" style="margin-top: 25px;">

	<div class="col-md-3 ">
		<div class="box-solid box">
			<div class="box-body">
				<p><b>Total Data Dalam Pencarian</b></p>
				<h3><b>{{$data->total()}} Data</b></h3>
			</div>
		</div>

		@if(isset($instansi))
		<div class="box-solid box c-fix hidden-sm hidden-xs"  data-spy="affix" data-offset-top="300">
			<div class="box-header text-center">
				<img style="max-height: 200px;" src="{{url($instansi->image_path)}}" class="img-thumbnail img-responsive">
			</div>
			<div class="box-body">
				<h3><b>{{str_replace('_',' ',str_replace('_', ' ', $instansi->type))}} - {{$instansi->name}}</b></h3>
				<p>{{$instansi->description}}</p>
			</div>
		</div>

		<div class="box-solid box hidden-md hidden-lg"  >
			<div class="box-header text-center">
				<img style="max-height: 200px;" src="{{url($instansi->image_path)}}" class="img-thumbnail img-responsive">
			</div>
			<div class="box-body">
				<h3><b>{{str_replace('_',' ',str_replace('_', ' ', $instansi->type))}} - {{$instansi->name}}</b></h3>
				<p>{{$instansi->description}}</p>
			</div>
		</div>

	@endif
	</div>
	<div class="col-md-9">
		<div class="col-md-12">
				@foreach($data as $d)
			<div class="info-box btn-ov hover-scale" style="overflow: hidden;">
            <span class="info-box-icon background-danger-y text-white hover-point">
            	@include('partials.icon-data',['type'=>$d->delivery_type])
            </span>
            <div class="info-box-content">
              <span class="info-box-text">
              	<a href="{{HPV::route_data($d)}}">{{$d->name}} - <b>{{$d->temas}}</b></a>
              </span>
             
              <span class="progress-description text-muted one-line">
                   {{$d->description}}
               </span>
               @if(strlen($d->description)>120)
               	<button class="btn btn-xs btn-info" style="font-size:8px;" onclick="showForm('{{route('api.data.desc',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')">Deskripsi Lengkap</button>
               @endif
                   <div class="progress">
              	<div class="progress"></div>
              </div>
                  	@if($d->delivery_type=='AUTOMATION')

                  	@elseif($d->type=='FILE')
                  		<div class="btn-group">
                  		<a href="{{url($d->document_path)}}" download="" class="btn btn-success btn-xs">Download</a>
                  	</div>
                  		

                  	@endif
                   {{Carbon\Carbon::parse($d->updated_at)->format('d F Y h:i')}} - <span class="badge bg-yellow"><b><a class="text-white" href="{{route('query.data.categorycal',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->organization_id,HPV::slugify($d->oranization_name)])}}">{{'@'.$d->oranization_name}}</a></b></span>
                  	
            </div>
            <!-- /.info-box-content -->
          </div>
			
		@endforeach

		@if(count($data)<1)
			<h5 class="text-center"><b>BELUM TERDAPAT DATA</b></h5>
		@endif
		{{$data->links()}}

		</div>

	</div>

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

		$(function(){
			setTimeout(function(){
			$('.affix, .affix-top').each(function(i,d){
				$(d).css('width',$(d)[0].with);
			});
			},500);
		})


	</script>
@stop