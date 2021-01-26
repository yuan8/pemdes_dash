@extends('vendor.adminlte.dashboard')

@section('content_header')
  <h2 class="text-center text-white" style="padding: 10px;"><b>JENIS PEKERJAAN</b></h2>
@stop


@section('content')

<div class="" id="container-1">

</div>

<div class="" id="container-2">

</div>

<div class="" id="container-3">

</div>

<div class="" id="container-4">

</div>

 

@stop



@section('js')
<script type="text/javascript">
  function get_point_1(){
    $('#container-1').html('<h5 class="text-center">Loading</h5>');

    $.get('{{route('d.pekerjaan.data')}}',function(res){
      $('#container-1').html(res);
      $('#container-2').html('');
      $('#container-3').html('');
      $('#container-4').html('');


    });
  }

  function get_point_2(url){
    scrollToDOM('#container-2');
    $('#container-2').html('<h5 class="text-center">Loading</h5>');

    $.get(url,function(res){
      $('#container-2').html(res);
      $('#container-3').html('');
      $('#container-4').html('');


    });
  }

  function get_point_3(url){
    scrollToDOM('#container-3');

    $('#container-3').html('<h5 class="text-center">Loading</h5>');

    $.get(url,function(res){
      $('#container-3').html(res);
      $('#container-4').html('');


    });
  }

  function get_point_4(url){
    scrollToDOM('#container-4');

    $('#container-4').html('<h5 class="text-center">Loading</h5>');

    $.get(url,function(res){
      $('#container-4').html(res);

    });
  }

get_point_1();

</script>
@stop
