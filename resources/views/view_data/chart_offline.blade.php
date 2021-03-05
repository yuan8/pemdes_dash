<!DOCTYPE html>
<html>
<head>
	<title>{{$title}}</title>
</head>
<style type="text/css">
	@php
		echo include(public_path('bower_components/bootstrap/dist/css/bootstrap.min.css'));
	@endphp
</style>
<script type="text/javascript">
	@php 
		echo include(public_path('vendor/adminlte/vendor/jquery/dist/jquery.min.js'));
		@endphp
</script>
<script type="text/javascript">
@php 
echo include(public_path('bower_components/highcharts/highstock.js'));
@endphp 

</script>
<script type="text/javascript">
<?=include(public_path('bower_components/highcharts/modules/map.js')); ?>
</script>
<script type="text/javascript">
	@php
	if($type=='map'){
		if($level==2)
		echo include(public_path('bower_components/L_MAP/ind/ind.js'));
		else{
			echo include(public_path('bower_components/L_MAP/idn_'.$kdparent.'.js'));
		}

	}
	@endphp
</script>
<script type="text/javascript">
		
</script>
<body>
	<h5 style="text-align: center">Updated Data At {{date('Y - m -d')}}</h5>
	<div class="" id="chart" style="width:calc(100vh- 30px); height: calc(100vh - 50px);"></div>

</body>

<script type="text/javascript">
		@if($type=='map')
		var map_chart=Highcharts.mapChart('chart', {
        chart: {
            backgroundColor: '#fff',
            exporting:{
            accessibility:{
             enabled:true
            }
            }

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
                    map_chart.fullscreen.close();
                    console.log('try close');
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
		@else
		var chart=Highcharts.chart('chart', {
		    chart: {
		        type: '{{$type}}',
		        height:'100vh',
		        marginLeft:100,
		        marginBottom:100,

		    },
		    title: {
		        text: '{{$title}}'
		    },
		    subtitle: {
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
		    yAxis:{
		      
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
		        {{$type}}: {
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
		              
		            }
		          }
		        }

		    },
		    series: <?=json_encode($data_type['series']) ?>
		});

	@endif
</script>
</html>