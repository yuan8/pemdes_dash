@extends('vendor.adminlte.dashboard')

@section('content_header')
<div class="row">
  <div class="col-md-12">
    <ol class="breadcrumb text-left">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active text-capitalize">Tema Data</li>
    </ol>
  </div>


</div>
@include('partials.banner_head',['placeholder_search'=>'Cari Data '.(isset($instansi)?ucfirst(strtolower($instansi->type)).' '.ucfirst(strtolower($instansi->name)):', Instansi, Tema'),'route_search'=>url()->full()])
@stop


@section('content')
<div class="container">
	<p class="text-center"><b>TEMA DATA UTAMA</b></p>
	<div class="row">
		@foreach ($data['data_utama'] as $element)
			<div class="col-md-2 col-sm-3">
				<a href="{{route('data.tema',['tahun'=>$GLOBALS['tahun_access'],'id'=>$element->id,'slug'=>HPV::slugify($element->name)])}}">
					<div class="box box-solid">
						<div class="box-header with-border">
						<img src="{{url($element->image_path)}}" style="max-width: 100%;">
							
						</div>
					<div class="box-body">
						<p><b>{{$element->name}}</b></p>
					</div>
				</div>
				</a>
			</div>
		@endforeach
	</div>
<p class="text-center"><b>TEMA DATA PENDUKUNG</b></p>
	<div class="row">
		@foreach ($data['data_pendukung'] as $element)
			<div class="col-md-2 col-sm-3">
				<a href="{{route('data.tema',['tahun'=>$GLOBALS['tahun_access'],'id'=>$element->id,'slug'=>HPV::slugify($element->name)])}}">
					<div class="box box-solid">
						<div class="box-header with-border">
						<img src="{{url($element->image_path)}}" style="max-width: 100%;">
							
						</div>
					<div class="box-body">
						<p><b>{{$element->name}}</b></p>
					</div>
				</div>
				</a>
			</div>
		@endforeach
	</div>

</div>

@stop 

