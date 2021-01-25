<?php
$id_dom='c_column_'.rand(0,100).'_'.date('is');
  ?>
<hr>
<div class="row" style="margin-bottom: 20px;">
  <div class="col-md-6" id="{{$id_dom}}" style="min-height:200px">

  </div>
  <div class="col-md-6" id="{{$id_dom}}_map" style="min-height:200px">

  </div>

</div>

@if($scope_map=='idn')
  <script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
@else


@endif

<script type="text/javascript">
Highcharts.chart('{{$id_dom}}', {
    chart: {
        type: 'bar',
        height:400,

    },
    title: {
        text: '{{$title}}'
    },
    subtitle: {
    },
    xAxis: {
      type: "category",
      min:0,
      max:5,
    },
    yAxis: {
        min: 0,

    },
    scrollbar:{
         enabled:true
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} {point.satuan}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        bar: {
            pointPadding: 0.2,
            borderWidth: 0,
            dataLabels: {
               enabled: true
           },
        },
        series:{
          events:{
            click:function(e){
              if(e.point.route!=undefined){
                @if(isset($child_f_prefix))
                {{$child_f_prefix}}e.point.route{{$child_f_surfix}}
                @endif
              }
            }
          }
        }

    },
    series: <?=json_encode($series) ?>
});

Highcharts.mapChart('{{$id_dom}}_map', {
    chart: {
        // type:'map',
        map:'ind',
        height:400,


    },
    title: {
        text: '{{$title}}'
    },
    subtitle: {
    },
   
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} {point.satuan}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        map: {
            pointPadding: 0.2,
            borderWidth: 0,
            // allAreas: false,
            joinBy: ['id', 'id'],
            dataLabels: {
               enabled: true
           },
        },
        series:{
          events:{
            click:function(e){
              if(e.point.route!=undefined){
                @if(isset($child_f_prefix))
                {{$child_f_prefix}}e.point.route{{$child_f_surfix}}
                @endif
              }
            }
          }
        }

    },
    series: <?=json_encode($series) ?>
});

</script>
