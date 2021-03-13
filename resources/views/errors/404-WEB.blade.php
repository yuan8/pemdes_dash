@php
	if(!isset($GLOBALS['tahun_access'])){
		$GLOBALS['tahun_access']=(int)date('Y');
	}
	if(!isset($GLOBALS['ab_message'])){
		$GLOBALS['ab_message']=[
			'title'=>'NOT FOUND'
		];
	}

@endphp

@extends('vendor.adminlte.dashboard')

@section('content_header')


	@include('partials.banner_head')

@stop

@section('content')
  <h2 class="text-center " style="padding-bottom: 10px;"><b>{{$GLOBALS['ab_message']['title']}}</b></h2>

	<div class="box box-solid" >
		<div class="box-body">
			<h5 class="text-center"><b>DATA TIDAK TERSEDIA</b></h5>
			<p class="text-center text-capitalize">Silahkan melakukan pencarian data lainya</p>
					</div>
	</div>

@stop