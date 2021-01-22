
@if($type=='FILE')
<i class="fa fa-file"></i>

@elseif($type=='DATASET')
<i class="fa fa-file"></i>
@elseif($type=='INFOGRAFIS')
<i class="fa fa-image"></i>
@elseif($type=='VISUALISASI')
<i class="fa fa-chart"></i>
@else
<i class="fa fa-times"></i>

@endif

