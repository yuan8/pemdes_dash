<?php
$id_dom='c_map_'.rand(0,100).'_'.date('is');
  ?>

@if($level==2)
  <script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
@else
  <script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_'.$kdparent.'.js')}}"></script>
@endif
   
<div style="width: 100%; height: 500;">
<div id="{{$id_dom}}" style="width:100%; max-height:100%"></div>
    
</div>

<script type="text/javascript">
var map_chart_{{$id_dom}}=Highcharts.mapChart('{{$id_dom}}', {
        chart: {
            backgroundColor: '#fff',
            exporting:{
            accessibility:{
             enabled:true
            }
            }

        },
      
        title: {
            text: 'KETERISIAN DATA {{$title}}',
            style:{
                color:'#222'
            },
            enabled:false
        },
        subtitle:{
            text:'{{$subtitle}}'
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
                    map_chart_{{$id_dom}}.fullscreen.close();
                    console.log('try close');
                }
              }
            }
        }
          
        },
        legend: {
            width:'100%',
            enabled: true,
            title:{
                text:'PERSENTASE KETERISIAN'
            }
        },
        exporting: {
            menuItemDefinitions: {
                viewFullscreen: {
                    text:'Fullscreen Mode',
                   
                },
                offline_mode:{
                    text:'Offline Mode',
                    onclick:function(){
                         var data=<?= json_encode(['type'=>'map','level'=>$level,'title'=>$title,'data_type'=>$data_type]) ?>;
                        var title=data.title;
                        data=btoa(JSON.stringify(data))

                        $.post('{{route('chart.offline',['tahun'=>$GLOBALS['tahun_access']])}}',{'data':data},function(res){
                               blob= new Blob([res+''], {type : 'text/html'});
                                // blob=res.blob();
                                console.log(blob);

                                const url = window.URL.createObjectURL(blob);
                                const a = document.createElement('a');
                                a.style.display = 'none';
                                a.href = url;
                                a.download = title+'.html';
                                document.body.appendChild(a);
                                a.click();
                                window.URL.revokeObjectURL(url);
                        });
      
                    }
                }
            },
            buttons: {
                contextButton: {
                     menuItems: ['viewFullscreen','offline_mode','downloadJPEG']
                }
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
                    map_chart_{{$id_dom}}.fullscreen.close();
                    console.log('try close');
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
<div id="xx_{{$id_dom}}">
    
</div>