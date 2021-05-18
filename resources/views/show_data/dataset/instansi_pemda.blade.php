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
      <div class="box-solid box c-fix hidden-sm hidden-xs" data-spy="affix" data-offset-top="300">
        <div class="box-header text-center">
          @if($instansi->image_path)
          <img style="max-height: 200px;" src="{{url($instansi->image_path??'')}}" class="img-thumbnail img-responsive">
          @endif
        </div>

        <div class="box-body">
          <h3><b>{{str_replace('_',' ',str_replace('_', ' ', $instansi->type))}} - {{$instansi->name}}</b></h3>
          <div class="btn-group ">
            <button class="btn btn-primary col-6">PROFILE CAPAIAN</button>
            <button class="btn btn-primary col-6">DATA</button>

          </div>
          <p>{{$instansi->deskripsi}}</p>
        </div>
      </div>

      <div class="box-solid box hidden-md hidden-lg">
        <div class="box-header text-center">
           @if($instansi->image_path)
          <img style="max-height: 200px;" src="{{url($instansi->image_path??'')}}" class="img-thumbnail img-responsive">
          @endif
        </div>
        <div class="box-body">
          <h3><b>{{str_replace('_',' ',str_replace('_', ' ', $instansi->type))}} - {{$instansi->name}}</b></h3>
          
          <p>{{$instansi->deskripsi}}</p>
        </div>
      </div>

      @endif
    </div>
    <div class="col-md-9">
      <div class="col-md-12 ">
        @foreach($data as $d)
        	@include('data.partials.data')
        @endforeach

        @if(count($data)<1)
        <h5 class="text-center"><b>BELUM TERDAPAT DATA</b></h5>
        @endif
        <div class="hh">
          {{$data->links()}}
        </div>

      </div>

    </div>

  </div>

  @stop

  @section('js')

  <style type="text/css">
    .c-fix {
      position: relative;
    }

    .affix.c-fix {
      position: fixed;
      z-index: 2;
      top: 55px;
    }

    .hh {
      display: none;
    }
  </style>

  <script type="text/javascript">
    var time_load = 300;
    $('.hh').each(function(i, d) {
      time_load += 50;
      setTimeout(function() {
        console.log(d);
        $(d).addClass('animate__animated animate__backInRight');

        $(d).removeClass('hh');

      }, time_load);
    });
    $(function() {
      setTimeout(function() {
        $('.affix, .affix-top').each(function(i, d) {
          $(d).css('width', $(d)[0].with);
        });
      }, 500);
    })
  </script>
  @stop