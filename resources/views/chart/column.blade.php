<?php
$id_dom='c_column_'.rand(0,100).'_'.date('is');
  ?>
<hr>
<div class="row">
  <div class="col-md-6" id="{{$id_dom}}" style="min-height:500px">

  </div>
  <div class="col-md-6" id="{{$id_dom}}_map" style="min-height:500px">

  </div>

</div>


<script type="text/javascript">
Highcharts.chart('{{$id_dom}}', {
    chart: {
        type: 'bar',

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

</script>
