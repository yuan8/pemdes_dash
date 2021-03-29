@extends('vendor.adminlte.dashboard')

@section('content_header')


	@include('partials.banner_head')

@stop

@section('content')
  	<h2 class="text-center " style="padding-bottom: 10px;"><b>{{isser($GLOBALS['ab_message'])?$GLOBALS['ab_message']['title']:''}}</b></h2>
	<div class="box box-solid">
		<div class="box-body">
			<h5 class="text-center"><b>DATA TIDAK DAPAT DIAKSES</b></h5>
			<p class="text-center text-capitalize">Data Membutuhkan Authentifikasi, Silahkan <a href="{{route('login')}}">Login</a> terlebih dahulu</p>
	</div>

@stop