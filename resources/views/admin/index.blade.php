@extends('vendor.adminlte.admin')
@section('content_header')

@stop
@section('content')


		<div class="row">
			<div class="col-md-12 text-center">
		<h4><b class="text-uppercase">Selamat Datang di Admin Panel Dashboard Bina Pemerintahan Desa</b></h4>

			<img src="{{url('logo.png')}}" style="max-height:200px; ">
			<h5><b>DIREKTORAT JENDERAL BINA PEMERINTAHAN DESA </b></h5>	
			<H5><b>Tahun Data {{$GLOBALS['tahun_access']}}</b></H5>
			</div>
		</div>

@stop


