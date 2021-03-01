<?php
$id_dom='c_map_'.rand(0,100).'_'.date('is');
  ?>

@if($level==2)
  <script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
@else
  <script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_'.$kdparent.'.js')}}"></script>
@endif
<div id="{{$id_dom}}" style="width:100%"></div>
<script type="text/javascript">
Highcharts.mapChart('{{$id_dom}}', {
        chart: {
            backgroundColor: '#fff',
            height:500,

        },
        title: {
            text: 'Keterisian {{$title}}',
            style:{
                color:'#222'
            },
            enabled:false
        },
        subtitle:{
            text:''
        },
        colorAxis: {
            maxColor:'{{isset($color_def)?$color_def:'#063a69'}}',
            labels: {
                format: '{value}'
            }
        },

        series:{
          map:{
            events:{
            click:function(e){
                 if(e.point.route!=undefined){
                    get_data('#dom_l_'+e.point.next_dom,e.point.route);
                }
              }
            }
        }
          
        },
        legend: {
            enabled: true,
            title:{
                text:'Persentase Tingkat Keterisian {{$title}}'
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
                data:  <?=json_encode($data_type['series_map']) ?>,
                events:{
                click:function(e){
                    if(e.point.route!=null){
                        get_data('#dom_l_'+e.point.next_dom,e.point.route);
                    }
                }
                },
                name: '',
                joinBy: 'id',
                type:'map',
                visible:true,
                mapData:Highcharts.maps['{{$level==2?'ind':'idn_'.$kdparent}}'],
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