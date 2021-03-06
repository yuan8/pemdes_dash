<?php
$id_dom='c_bar_'.rand(0,100).'_'.date('is');
 ?>
   
 
<div id="{{$id_dom}}" style="width:100%"></div>


<script type="text/javascript">
	
var bar_chart_{{$id_dom}}=Highcharts.chart('{{$id_dom}}', {
    chart: {
        type: 'bar',
        height:500,
        marginLeft:100,
        marginBottom:100,

    },
    title: {
        text: '{{$title}}'
    },
   subtitle:{
            text:'{{$subtitle}}'
        },
    xAxis: {
      type: "category",
      margin:0.1,
      labels:{
        text:''
      },
      min:0,
      max:3,
      maxPadding:3,
      labels:{
        distance:1,
        padding:0
      }
    },
    yAxis:<?= count($data_type['series']['yAxis'])>0?json_encode($data_type['series']['yAxis']):'{}' ?>,
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
          groupPadding:0.1,
            dataLabels: {
               enabled: true,
               inside:true,
               align:"right",
               format:"{point.y:,.0f} {point.satuan}",
               crop:false,
               // overflow:"allow",
           },
        },
        series:{
          events:{
            click:function(e){
              if(e.point.route!=undefined){
                get_data('#dom_l_'+e.point.next_dom,e.point.route);
              }
            }
          }
        }

    },
    series: <?=json_encode($data_type['series']['data']) ?>
});


function fls_bar_{{$id_dom}}(){
        bar_chart_{{$id_dom}}.fullscreen.toggle()
}

</script>