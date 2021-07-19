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
	@include('partials.banner_head',['placeholder_search'=>'Cari Data '.(isset($instansi)?ucfirst(strtolower($instansi->type)).' '.ucfirst(strtolower($instansi->name)):', Instansi, Tema'),'route_search'=>route('query.data',['tahun'=>$GLOBALS['tahun_access']])])
@stop
@section('content')
<div class="box box-solid">
	<div class="box-header with-border">
		<h4 class="text-center" ><b>{{strtoupper($data->title)}} - {{$GLOBALS['tahun_access']}}</b></h4>
			<div class="box-solid box btn-ov " style="border: 1px solid #fa090a">
	  		<div class="box-body">
	  			<p>{!!nl2br($data->deskripsi)!!}</p>
	  		</div>
	  	</div>
	</div>
	<div class="box-body text-center ">
		@if($data->extension=='pdf')
		<iframe src="{{url($data->path_file)}}" style="width:100%; min-height:200vh"></iframe>


		@else
		<img src="{{url($data->path_file)}}" class="img-responsive">

		@endif
	</div>
</div>

@stop