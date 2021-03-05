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
	@include('partials.banner_head')
@stop
@section('content')

<div class="row" style="margin-top: 25px;">

	<div class="col-md-3">
		<div class="box-solid box">
			<div class="box-body">
				<p><b>Total Data Dalam Pencarian</b></p>
				<h3><b>{{$data->total()}} Data</b></h3>
			</div>
		</div>

		@if(isset($instansi))
		<div class="box-solid box c-fix"  data-spy="affix" data-offset-top="200">
			<div class="box-header text-center">
				<img style="max-height: 200px;" src="{{url($instansi->image_path)}}" class="img-thumbnail img-responsive">
			</div>
			<div class="box-body">
				<h3><b>{{str_replace('_PRIMER','',str_replace('_SEKUNDER', '', $instansi->type))}} - {{$instansi->name}}</b></h3>
				<p>{{$instansi->description}}</p>
			</div>
		</div>

	@endif
	</div>
	<div class="col-md-9">
		@foreach($data as $d)
			<div class="info-box ">
            <span class="info-box-icon background-primary text-white">
            	@include('partials.icon-data',['type'=>$d->delivery_type])
            </span>
            <div class="info-box-content">
              <span class="info-box-text">
              	<a href="{{HPV::route_data($d)}}">{{$d->name}}</a>
              </span>
             
              <span class="progress-description text-muted">
                   {{$d->description}}
                  </span>
                   <div class="progress">
              	<div class="progress"></div>
              </div>
                  	@if($d->delivery_type=='AUTOMATION')

                  	@elseif($d->type=='DATASET')
                  		<div class="btn-group">
                  		<a href="{{url($d->document_path)}}" download="" class="btn btn-success btn-xs">Download</a>
                  		<a href="{{route('query.data.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'slug'=>'ddd'])}}" class="btn btn-info btn-xs">Lihat Data</a>

                  		</div>

                  	@endif
                   - {{Carbon\Carbon::parse($d->updated_at)->format('d F Y h:i')}}
                  	
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