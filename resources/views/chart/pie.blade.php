<?php
$id_dom='c_pie_'.rand(0,100).'_'.date('is');
 ?>
 <div class="row">
 <?php foreach ($series as $key => $value): ?>

    <div class="col-md-4" id="{{$id_dom.'_'.$key}}" ></div>

   <script type="text/javascript">
    Highcharts.chart('{{$id_dom.'_'.$key}}', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: '{{$series[$key]['name']}}'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
            format: '<b>{point.name}</b>: {point.percentage:.1f}% '
          }
        }
      },
      series: [<?=json_encode($value)?>]
    });
</script>

  
 <?php endforeach ?>


</div>
