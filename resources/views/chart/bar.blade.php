<?php
$id_dom='c_bar_'.rand(0,100).'_'.date('is');
 ?>
 
<div id="{{$id_dom}}" style="width:100%"></div>


<script type="text/javascript">
	
var xx=Highcharts.chart('{{$id_dom}}', {
    chart: {
        type: 'bar',
        height:500,
        marginLeft:100,

    },
    title: {
        text: '{{$title}}'
    },
    subtitle: {
    },
    xAxis: {
      type: "category",
      margin:0.1,

      min:0,
      max:3,
      maxPadding:3,
      labels:{
        distance:1,
        padding:0
      }
    },
    yAxis: 
        @if(isset($satuan))
         [
         @foreach($satuan as $key=>$s)
          { 
          labels: {
            format: '{value} {{$s['satuan']}}',
          },
          title: {
            text: '{{$s['title']}}',
            
          },
          @if($key==0)
            opposite: true
          @endif
          },
          @endforeach
          ],
         
        @else
        {
        min: 0,
        },

        @endif
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