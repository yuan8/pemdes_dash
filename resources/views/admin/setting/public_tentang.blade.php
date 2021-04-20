@extends('vendor.adminlte.dashboard')

@section('content_header')

	@include('partials.banner_head')

@stop


@section('content')
<h4 class="text-center"><b>TENTANG KAMI</b></h4>
<div class="box ">
	<div class="box-body">
		<div class="row">
	<div class="col-md-3 text-center">
		<img src="{{asset('logo.png')}}" style="width: 200px; ">
		
	</div>
	<div class="col-md-9">
		{!!$data['value']!!}
	</div>
	
</div>
	</div>
</div>
@stop
