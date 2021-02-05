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
            backgroundColor: 'transparent',
            height:500,

        },
        title: {
            text: '{{$title}}',
            style:{
                color:'#222'
            },
            enabled:false
        },
        subtitle:{
            text:''
        },
        colorAxis: {
           
            labels: {
                format: '{value}'
            }
        },
        series:{
          map:{
            events:{
            click:function(e){
                if(e.point.route!=undefined){
                console.log('{{$child_f_prefix}}');
                @if(isset($child_f_prefix))
                {{$child_f_prefix}}e.point.route{{$child_f_surfix}}
                @endif
              }
            }
             }
          }
        },
        legend: {
            enabled: true,
            title:{
                text:'{{isset($legend_map)?$legend_map:''}}'
            }
        },
        // credits: {
        //     enabled: false
        // },
        tooltip: {
            headerFormat: '',
            formatter: function() {
                if(this.point.data_map!=undefined){
                    var dom='<ul><li><b>'+this.point.name+'</b><br></li>';
                    for (var i = 0; i < this.point.data_map.length; i++) {
                        dom+='<li>'+this.point.data_map[i].name+' : '+this.point.data_map[i].y+' '+this.point.data_map[i].satuan+"<br></li>";
                    }
                    dom+="</ul>";
                    return dom;
                }else{
                    return this.point.name;
                }

            }
        },

         mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
            }
        },
        series:[

                    {
                        data: <?= json_encode($series_map) ?>,
                        events:{
                        click:function(e){
                            if(e.point.route!=undefined){
                            console.log('{{$child_f_prefix}}');
                            @if(isset($child_f_prefix))
                            {{$child_f_prefix}}e.point.route{{$child_f_surfix}}
                            @endif
                          }
                        }
                        },
                        name: '',
                        joinBy: 'id',
                        type:'map',
                        visible:true,
                        mapData:Highcharts.maps['{{$scope_map=='idn'?'ind':$scope_map}}'],
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}',
                            color: '#fff',
                            style: {
                                fontSize: 9,
                                font: '9px Trebuchet MS, Verdana, sans-serif'
                            },
                        },
                        color:'{point.color}',
                        states: {
                            hover: {
                                color: '#BADA55'
                            }
                        },
                    }

                ]

            });



</script>