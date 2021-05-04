<?php
$id_dom='c_column_'.rand(0,100).'_'.date('is');
 ?>
   
 
<div id="{{$id_dom}}" style="width:100%"></div>


<script type="text/javascript">
	
var column_chart_{{$id_dom}}=Highcharts.chart('{{$id_dom}}', {
    chart: {
        type: 'column',
        height:500,
        marginLeft:100,
        marginBottom:100,

    },
    title: {
        text: '{{$title}}'
    },
      exporting: {
            menuItemDefinitions: {
                viewFullscreen: {
                    text:'Fullscreen Mode',
                   
                },
                offline_mode:{
                    text:'Offline Mode',
                    onclick:function(){
                         var data=<?= json_encode(['type'=>'column','level_meta'=>$level_meta,'table_meta'=>$table_meta,'level'=>$level,'title'=>$title,'data_type'=>$data_type]) ?>;
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
       scrollbar: {
            enabled: true
        },
    },
    yAxis:<?= count($data_type['series']['yAxis'])>0?json_encode($data_type['series']['yAxis']):'{}' ?>,
    scrollcolumn:{
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
        column: {
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


function fls_column_{{$id_dom}}(){
        column_chart_{{$id_dom}}.fullscreen.toggle()
}

</script>