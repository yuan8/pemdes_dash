@extends('vendor.adminlte.dashboard')


@section('content_header')
  <h2 class="text-center text-white" style="padding: 10px;"><b>{{$title}}</b></h2>

@stop
@section('content')
	<br>
	<h3 class="text-center"><b style="color:#fff">HALAMAN SEDANG DALAM PERBAIKAN</b></h3>
	<hr>
	<div class="text-center">
		<img src="{{url('const.jpeg')}}" class="text-center">
	</div>
	<style type="text/css">
		.content{
			background: #11049c;
			padding-top: 10px;
			min-height: 78vh;
		}
		.container-full{
			background: #11049c;

		}
	</style>
@stop