<?php
	$id_dom='c_pie_'.rand(0,100).'_'.date('is');
 ?>
 <div id="{{$id_dom}}" style="width:100%"></div>


<script type="text/javascript">
	
var pie_chart_{{$id_dom}}=Highcharts.chart('{{$id_dom}}', {
    chart: {
        type: 'pie',
        height:500,
        marginLeft:100,
        marginBottom:100,
        options3d: {
	      enabled: true,
	      alpha: 45,
	      beta: 0
	    }

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
                         var data=<?= json_encode(['type'=>'pie','level_meta'=>$level_meta,'table_meta'=>$table_meta,'level'=>$level,'title'=>$title,'data_type'=>$data_type]) ?>;
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
   
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}% - {point.y} {point.satuan}  </b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: <?=json_encode(array_values(array_merge($data_type['data_sort']['max'],$data_type['data_sort']['else_max'])))?>
    }]
});

</script>