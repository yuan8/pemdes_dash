<?php
$id_dom='c_bar_'.rand(0,100).'_'.date('is');
 ?>
 
<div id="{{$id_dom}}" style="width:100%"></div>


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
</script>