@extends('vendor.adminlte.admin')
@section('content_header')
<h4>PENGISIAN DATA TIDAK TERSEDIA</h4>
@php
@endphp
<h4>{{$nama_data}}</b></h4>
@stop

@section('content')

<h5 class="text-center"><b>JADWAL PENGISIAN {{$nama_data}}</b></h5>
@if($jadwal)
<p class="text-center"><b>JADWAL PENGISIAN DATA DIMULAI {{Carbon\Carbon::parse($jadwal['mulai'])->format('d F Y h:i a')}} - {{Carbon\Carbon::parse($jadwal['selesai'])->format('d F Y h:i a')}} (WIB) </b></p>
@else
<p class="text-center"><b>JADWAL PENGISIAN DATA BELUM TERSEDIA</b></p>
@endif
@stop

