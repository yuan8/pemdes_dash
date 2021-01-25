@extends('vendor.adminlte.dashboard_white')

@section('content_header')
  <h2 class="text-center text-white" style="padding: 10px;"><b>KEPENDUDUKAN</b></h2>
@stop


@section('content')

<div class="" id="container-1">

</div>

<div class="" id="container-2">

</div>

<div class="" id="container-3">

</div>

 

@stop



@section('js')
<script type="text/javascript">
  function get_point_1(){
    $('#container-1').html('<h5 class="text-center">Loading</h5>');

    $.get('{{route('d.kependudukan.chart.p')}}',function(res){
      $('#container-1').html(res);
      $('#container-2').html('');
      $('#container-3').html('');

    });
  }

  function get_point_2(url){
    scrollToDOM('#container-2');
    $('#container-2').html('<h5 class="text-center">Loading</h5>');

    $.get(url,function(res){
      $('#container-2').html(res);
      $('#container-3').html('');

    });
  }

  function get_point_3(url){
    scrollToDOM('#container-3');

    $('#container-3').html('<h5 class="text-center">Loading</h5>');

    $.get(url,function(res){
      $('#container-3').html(res);

    });
  }

get_point_1();

</script>
@stop
