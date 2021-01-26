<?php
  $id_dom=rand(0,1000).date('is');
 ?>
<div class="box box-solid">
  <div class="box-header with-border">
    <h5 class="text-center" ><b>{{isset($title)?$title:''}}</b></h5>
  </div>
  <div class="box-body">
    <table class="table table-bordered" id="table-{{$id_dom}}">
      <thead>
        <th>NO</th>
        <th>ACTION</th>
        <th>KODE DAERAH</th>
        <th>NAMA DAERAH</th>

        <?php foreach ($series as $key => $value): ?>
          <th>{{strtoupper($value['name'])}}</th>
        <?php endforeach; ?>
      </thead>
      <tbody>
        <?php if (isset($series[0])): ?>
          <?php foreach ($series[0]['data'] as $key => $d): ?>
            <tr>

            <td>{{$key+1}}</td>
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
