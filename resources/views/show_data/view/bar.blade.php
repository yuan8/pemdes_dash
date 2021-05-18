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
        // marginRight:100,
        marginBottom:100,
        // spacingBottom:120,

    },
    legend:{
      enabled:false,
     maxHeight:300,
     maxWidth:100,
     backgroundColor:'#f1f1f1',
     overflow:'auto'

},
      exporting: {
            menuItemDefinitions: {
                viewFullscreen: {
                    text:'Fullscreen Mode',
                   
                },
                offline_mode:{
                    text:'Offline Mode',
                    onclick:function(){
                             var data=<?= json_encode(['type'=>'bar','level_meta'=>$level_meta,'table_meta'=>$table_meta,'level'=>$level,'title'=>$title,'data_type'=>$data_type]) ?>;
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
                },
                show_label:{
                  text:'Legenda',
                  onclick:function(){
                    console.log(this);
                    if(this.legend.options.enabled){
                      this.legend.options.enabled=false;
                    }else{
                      this.legend.options.enabled=true;
                    }
                    this.legend.update();

                    console.log(this.legend.options.enable);
                  }
                }
            },
            buttons: {
                contextButton: {
                     menuItems: ['viewFullscreen','offline_mode','downloadJPEG','show_label']
                }
            }
          },
    title: {
        text: '{{$title}} {{strtoupper($pemda)}}'
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
      },
      scrollbar:{
         enabled:true
    },
    },
    yAxis:<?= count($data_type['series']['yAxis'])>0?json_encode($data_type['series']['yAxis']):'{}' ?>,
    
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