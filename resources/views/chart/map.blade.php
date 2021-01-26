<?php
$id_dom='c_map_'.rand(0,100).'_'.date('is');
  ?>

@if($scope_map=='idn')
  <script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
@else
  <script type="text/javascript" src="{{asset('bower_components/L_MAP/'.$scope_map.'.js')}}"></script>
@endif
<div id="{{$id_dom}}" style="width:100%"></div>
<script type="text/javascript">
	Highcharts.mapChart('{{$id_dom}}', {
    chart: {
        // type:'map',
        map:'{{$scope_map}}',
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
            joinBy: 'id',
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
    series:[
    {
    	name:"",
    	data:<?=json_encode($series_map) ?>
    }
    ]
});


</script>