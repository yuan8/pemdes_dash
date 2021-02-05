<?php
  $id_dom=rand(0,1000).date('is');
 ?>
<div class="box box-solid">
  <div class="box-header with-border">
    <h5 class="text-center" ><b>{{isset($title)?$title:''}}</b></h5>
  </div>
  <div class="box-body table-responsive">
    <table class="table table-bordered" id="table-{{$id_dom}}">
      <thead>
        <tr>
          <th rowspan="2">ACTION</th>
          <th rowspan="2">KODE DAERAH</th>
          <th rowspan="2" >NAMA DAERAH</th>

          <?php foreach ($series as $key => $value): ?>
            <th colspan="2">{{strtoupper($value['name'])}}</th>

          <?php endforeach; ?>
        </tr>
        <tr>
          <?php foreach ($series as $key => $value): ?>
            <th >NILAI</th>
            <th >SATUAN</th>
          <?php endforeach; ?>
          
        </tr>
        <tr>
          <th>1</th>
          <th>2</th>
          <th>3</th>
          <?php foreach ($series as $key => $value): ?>
            <th >{{($key*2)+4}}</th>
            <th >{{($key*2)+5}}</th>
          <?php endforeach; ?>

        </tr>
      </thead>
      <tbody>
        <?php if (isset($series[0])): ?>
          <?php foreach ($series[0]['data'] as $key => $d): ?>
            <tr>

            <td>
              @if(isset($series[0]['data'][$key]['route']))

              @if(isset($child_f_prefix))
             
                <button class="btn btn-primary btn-xs" onclick="{{isset($child_f_prefix)?($child_f_prefix."'".$series[0]['data'][$key]['route']."'".$child_f_surfix):'javascript:void(0)'}}">Detail</button>
                @else
                -
                @endif
              @endif

            </td>
            <td>{{$series[0]['data'][$key]['id']}}</td>
            <td>{{strtoupper($series[0]['data'][$key]['name'])}}</td>

              <?php for ($i=0;$i<count($series);$i++): ?>

                  <td>{{number_format($series[$i]['data'][$key]['y'])}}</td>
                  <td>{{($series[$i]['data'][$key]['satuan'])}}</td>



              <?php endfor; ?>
            </tr>

          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>

    </table>


  </div>

</div>

<script type="text/javascript">
  $('#table-{{$id_dom}}').DataTable({
    'lengthChange':false,
    'pageLength':100000,
    'paging':false,
    "info": false
  });
</script>
